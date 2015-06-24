<?php

class Junar {

    /**
     * Base class, contains the configuration
     */
    private $authkey = '';
    private $baseUri = '';

    public function __construct() {
    	$CI = &get_instance();
        $this->authkey = $CI->config->item('junar_authkey');
        $this->baseUri = $CI->config->item('junar_baseuri');
        $this->dev_file_cache = $CI->config->item('junar_development_file_cache');
    }

    public function datastream($guid = '') {
        /**
         * Creates a datastream object.
         *
         * @param string $guid the guid of the datastream
         */
        return new DataStream($guid, $this->authkey, $this->baseUri);
    }

    public function dashboard($guid) {
        /**
         * Creates a datastream object.
         *
         * @param string $guid the guid of the datastream
         */
        return new Dashboard($guid, $this->authkey, $this->baseUri);
    }

    public function resource() {
        return new Resource($this->authkey, $this->baseUri);
    }

    /**
     * @return SimpleXMLElement
     */
    public function ultimoCatalogo(){
        $fileName = 'catalog.xml';
        if($this->dev_file_cache && file_exists($fileName)){
            $response = file_get_contents($fileName);
        } else {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_URL, $this->baseUri . $fileName);

            $response = curl_exec($ch);
            file_put_contents($fileName, $response);
            curl_close($ch);
        }

        $xmlResponse = new SimpleXMLElement($response);
        $xmlResponse->registerXPathNamespace('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
        $xmlResponse->registerXPathNamespace('foaf', 'http://xmlns.com/foaf/0.1/');
        $xmlResponse->registerXPathNamespace('owl', 'http://www.w3.org/2002/07/owl#');
        $xmlResponse->registerXPathNamespace('rdfs', 'http://www.w3.org/2000/01/rdf-schema#');
        $xmlResponse->registerXPathNamespace('dcat', 'http://www.w3.org/ns/dcat#');
        $xmlResponse->registerXPathNamespace('ods', 'http://open-data-standards.github.com/2012/01/open-data-standards#');
        $xmlResponse->registerXPathNamespace('dct', 'http://purl.org/dc/terms/');

        return $xmlResponse;
    }

}

class DataStream {

    private $guid = '';
    private $authkey = '';
    private $baseUri = 'http://api.recursos.datos.gob.cl';
    private $response = null;
    private $output = '';

    public function __construct($guid, $authkey, $baseUri = 'http://api.recursos.datos.gob.cl') {
        /**
         * It can be used to invoke a datastream (that means, to get its data), and to get metada about it
         *
         * @param string guid the guid of the datastream
         * @param string auth_key your auth_key to access the API
         * @param string base_uri the base uri of the API
         */
        $this->guid = $guid;
        $this->authkey = $authkey;
        $this->baseUri = $baseUri;
    }

    public function invoke($params = array(), $output = '', $page = null, $limit = null) {
        /**
         * Gets the datastream's data.
         *
         * @param array params an array of the parameters, (parameters are positional)
         * @param string output the format in which the document will be returned
         *        for default junar json leave output blank, its structure is explained
         *        here http://wiki.junar.com/index.php/API#JSON_Structure
         *        other options are:
         *         - prettyjson use this, with the collect tool at www.junar.com,
         *                      by enabling the advanced mode, and select "Add aliases", then follow the instructions
         *         - json_array, basic javascript array of arrays, in python a list of lists
         *         - csv
         *         - tsv
         *         - excel
         *         - xml, prettyjson sister, configuration here is not mandatory
         * @param int page the page number of the data, use in combination with limit
         * @param int limit the limit of the data to return, use in combination with page
         */
        if ($this->authkey == '') {
            throw new Exception('Please configure your auth_key, get one at http://www.junar.com/developers/');
        }

        $query = array('auth_key' => $this->authkey);

        // create the URL
        $i = 0;
        foreach ($params as $param) {
            $query["pArgument$i"] = $param;
            $i++;
        }

        if ($output != '') {
            $this->output = $output;
            $query['output'] = $output;
        }

        if (!is_null($page) && !is_null($limit)) {
            $query['page'] = $page;
            $query['limit'] = $limit;
        }

        $url = "/datastreams/invoke/{$this->guid}?" . http_build_query($query);
        return $this->__callURI($url);
    }

    public function info() {
        /**
         * Gets the datastream's metadata.
         */
        // create the URL
        $url = "/datastreams/{$this->guid}?auth_key={$this->authkey}";
        return $this->__callURI($url);
    }

    public function search($find) {
        $url = "/datastreams/search?query={$find}&max_results=5&auth_key={$this->authkey}";
        return $this->__callURI($url);
    }

    public function __callURI($url) {
    		$ch = curl_init();
			 
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_URL, $this->baseUri . $url);

            $response = curl_exec($ch);
            curl_close($ch);

        // parsing the content
        if (in_array($this->output, array('', 'prettyjson', 'json_array'))) {
            $this->response = @json_decode($response, true);
        } else {
            $this->response = $response;
        }

        return $this->response;
    }

}

class Dashboard {

    public function __construct($guid, $authkey, $baseUri = 'http://api.recursos.datos.gob.cl') {
        /**
         * It can be used to invoke a datastream (that means, to get its data), and to get metada about it
         *
         * @param string guid the guid of the datastream
         * @param string auth_key your auth_key to access the API
         * @param string base_uri the base uri of the API
         */
        $this->guid = $guid;
        $this->authkey = $authkey;
        $this->baseUri = $baseUri;
    }

    public function dashboard() {
        $url = "/dashboards/{$this->guid}?auth_key={$this->authkey}";
        return $this->__callURI($url);
    }

    public function __callURI($url) {
				$ch = curl_init();
			 
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
				curl_setopt($ch, CURLOPT_URL, $this->baseUri . $url);
			 
				$response = curl_exec($ch);
				curl_close($ch);

        $this->response = $response;

        // parsing the content
        if (isset($this->output))
            if (in_array($this->output, array('', 'prettyjson', 'json_array')))
                $this->response = @json_decode($this->response, true);

        return $this->response;
    }

}

class Resource {

    public function __construct($authkey, $baseUri = 'http://api.recursos.datos.gob.cl') {
        /**
         * It can be used to invoke a datastream (that means, to get its data), and to get metada about it
         *
         * @param string guid the guid of the datastream
         * @param string auth_key your auth_key to access the API
         * @param string base_uri the base uri of the API
         */
        //$this->guid = $guid;
        $this->authkey = $authkey;
        $this->baseUri = $baseUri;
    }

    public function resource($meta) {
        $url = "/resources/search?meta=".$meta."&auth_key=".$this->authkey;
        return $this->__callURI($url);
    }

    public function __callURI($url) {
    		$ch = curl_init();
			 
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
				curl_setopt($ch, CURLOPT_URL, $this->baseUri . $url);
			 
				$response = curl_exec($ch);
				curl_close($ch);

        $this->response = $response;
        // parsing the content
        if (isset($this->output))
            if (in_array($this->output, array('', 'prettyjson', 'json_array')))
                $this->response = @json_decode($response, true);

        return $this->response;
    }

}