<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cronjunar extends CI_Controller {

    /**
     * @var Doctrine
     */
    public $doctrine;

    public $tipos_recurso = ['conjuntos', 'vistas', 'visualizaciones', 'colecciones'];

    /**
     * @var Junar
     */
    public $junar;

    /**
     * @var SimpleXMLElement
     */
    protected $catalogo;

    /**
     * @var SimpleXMLElement
     */
    protected $datasets;

    /**
     * @var \Repositories\VistaJunar
     */
    protected $vistasJunar;

    /**
     * @var \Repositories\Recurso
     */
    protected $recursos;

    /**
     * @var \Repositories\Dataset
     */
    protected $datasetRepository;

    protected $totalVistas = 0;

    function __construct() {
        parent::__construct();
        if (!$this->input->is_cli_request()) return show_404();
        $this->load->library('Junar');
    }

    /**
     * Metodo principal entrada para la sincronización del portal con Junar
     */
    public function sync() {
        $this->recursos = $this->doctrine->em->getRepository('Entities\Recurso');
        $this->vistasJunar = $this->doctrine->em->getRepository('Entities\VistaJunar');
        $this->datasetRepository = $this->doctrine->em->getRepository('Entities\Dataset');

        //Obtiene la ultima fecha de actualización desde Junar
        $ultimaActualizacion = new DateTime();
        log_message('info', 'Ultima sincronización: ' . $ultimaActualizacion->format('Y-m-d'));

        log_message('info', 'Obteniendo catalogo con los datasets...');
        $this->catalogo = $this->junar->ultimoCatalogo();
        $this->datasets = $this->catalogo->xpath('dcat:Dataset');
        $this->datasets = $this->normalizaDatasets($this->datasets);
        log_message('info', 'Catalogo obtenido, total de datasets:' . count($this->catalogo));

        $this->aplicaActualizacionesCatalogo();

        log_message('info', 'Sincronización completada, total de vistas actualizadas:' . $this->totalVistas);
    }

    /**
     * @param $xmlElement SimpleXMLElement||array
     * @return array
     */
    protected function getArrayFromXml($xmlElement){
        $array = array();
        if(gettype($xmlElement) == 'object' && get_class($xmlElement) == 'SimpleXMLElement'){
            $namespaces = $xmlElement->getNamespaces(true);
            foreach($namespaces as $namespace => $href){
                //Attributes
                $attributes = $xmlElement->attributes($namespace, '*');
                if (count($attributes)) {
                    foreach ($attributes as $key => $attribute) {
                        $array[(string)$key] = (string)$attribute;
                    }
                }

                //Values
                $elements = array_merge($array, (array)$xmlElement->children($namespace, true));
                foreach($elements as $key => $element){
                    $array[$key] = $this->getArrayFromXml($element);
                }
            }
        } elseif (gettype($xmlElement) == 'array'){
            foreach($xmlElement as $key => $element){
                $array[$key] = $this->getArrayFromXml($element);
            }
        } else {
            $array = $xmlElement;
        }

        return $array;
    }

    /**
     * Aplica las actualizaciones obtenidas al portal de datos
     */
    private function aplicaActualizacionesCatalogo() {
        foreach ($this->datasets as $dataset) {
            $vistas = $this->normalizaVistasDataset($dataset);
            $this->creaVistasDataset($dataset, $vistas);
        }
    }

    /**
     * Normaliza los datasets obtenidos del XML a un Array
     *
     * @param $datasets
     * @return array
     */
    private function normalizaDatasets($datasets) {
        $datasetsNormalizdos = array();
        foreach ($datasets as $key => $datasetElement) {
            $dataset = $this->getArrayFromXml($datasetElement);
            if(isset($dataset['meta'])) {
                $dataset['dataset_id'] = $this->getDatasetId($dataset);
                $datasetsNormalizdos[] = $dataset;
            }else {
                log_message('warning', 'El Dataset [' . $dataset['identifier'] . '] no se puede enlazar con el portal, falta campo "meta" con la Url del dataset');
            }
        }
        return $datasetsNormalizdos;
    }

    /**
     * Obtiene el dataset ID desde una dataset en el Catalogo
     * @param $dataset
     * @return mixed|null
     */
    protected function getDatasetId($dataset){
        $dataset_id = null;
        $url = $dataset['meta'];
        $parsedUrl = parse_url($dataset['meta']);
        if(isset($parsedUrl['path'])){
            $segments = explode('/', $parsedUrl['path']);
            $dataset_id = array_pop($segments);
        }
        return $dataset_id;
    }

    /**
     * Normaliza los distintos tipos de vistas del catalogo
     * 'conjuntos','vistas','visualizaciones','colecciones'
     *
     * @param $dataset
     * @return array
     */
    private function normalizaVistasDataset($dataset) {
        $vistas = array();
        if(isset($dataset['chart'])){
            $charts = $dataset['chart'];
            if(isset($charts['title']))
                $charts = array($charts);
            $vistas = array_merge($vistas, $this->getVistasChart($dataset, $charts));
        }
        return $vistas;
    }

    /**
     * Crea las vistas del catalogo en la BD
     *
     * @param $dataset
     * @param $vistas
     */
    public function creaVistasDataset($dataset, $vistas){
        foreach ($vistas as $vistaDataset) {
            try {
                $vistaActual = $this->vistasJunar->findOneBy(array('junar_guid' => $vistaDataset['junar_guid']));
                //Si no existe la vista se debe crear un nuevo recurso para esta
                if(!$vistaActual) {
                    $datasetRecurso = $this->datasetRepository->find($vistaDataset['meta_data']);
                    if(!$datasetRecurso)
                        throw new Exception('No se ha encontrado el dataset [' . $vistaDataset['meta_data'] . '], no es posible crear la vista.');

                    $recursoVista = $this->recursos->creaRecurso(array(
                        'descripcion' => $vistaDataset['description'],
                        'url' => $vistaDataset['source']
                    ), $datasetRecurso);

                    $vistaActual = new Entities\VistaJunar;
                    $vistaActual->setRecurso($recursoVista);
                    $vistaActual->setCreatedAt(new DateTime());
                    $vistaActual->setUpdatedAt(new DateTime());
                }

                $vistaActual->setJunarGuid($vistaDataset['junar_guid']);
                $vistaActual->setTitle($vistaDataset['title']);
                $vistaActual->setDescription($vistaDataset['description']);
                $vistaActual->setSource($vistaDataset['source']);
                $vistaActual->setCategory($vistaDataset['category']);
                $vistaActual->setMetaData($vistaDataset['meta_data']);
                $vistaActual->setTableId($vistaDataset['table_id']);
                $vistaActual->setType($vistaDataset['type']);
                $vistaActual->setTags($vistaDataset['tags']);

                $this->doctrine->em->persist($vistaActual);
                $this->doctrine->em->flush();
                $this->totalVistas++;
            } catch (Exception $e){
                log_message('error', $e->getMessage());
            }
        }
    }

    /**
     * Obtiene las vistas de tipo chart de un dataset
     *
     * @param $dataset
     * @param $charts
     * @return array
     */
    protected function getVistasChart($dataset, $charts){
        $vistas = [];
        foreach ($charts as $chart) {
            $vistas[] =  array(
                'junar_guid' => $chart['identifier'],
                'title' => $chart['title'],
                'description' => $chart['description'],
                'source' => $chart['accessURL'],
                'category' => '',
                'meta_data' => $dataset['dataset_id'],
                'table_id' => 0,
                'type' => 'vistas',
                'tags' => ''
            );
        }

        return $vistas;
    }



    /*
     * OLD
     */


    private function aplicaCambiosRecurso($recurso, $tipoRecurso, $tipoCambio) {
        switch ($tipoCambio) {
            case 'publicados':
                $this->creaVista($recurso, $tipoRecurso);
                break;
            case 'modificados':
                $this->actualizaVista($recurso, $tipoRecurso);
                break;
            case 'despublicados':
                $this->despublicaVista($recurso, $tipoRecurso);
                break;
        }
    }

    protected function buscaDataEnCatalogo($recurso, $tipo_recurso) {
        $datasets = array();
        $guid = $recurso['GUID'];
        $searchQuery = "dcat:Dataset/dct:identifier//text()[contains(., '" . $guid . "')]/../..";
        $cambios = $this->catalogo->xpath($searchQuery);
        foreach ($cambios as $key => $datasetElement) {
            $dataset = $this->getArrayFromXml($datasetElement);
            var_dump($dataset);die;
            $datasets[$key] = $dataset;
        }
        return $datasets;
    }

    private function creaVista($recurso, $tipoRecurso) {
        try {
            $data = $this->buscaDataEnCatalogo($recurso, $tipoRecurso);
            file_put_contents('catalog.json', json_encode($data, JSON_PRETTY_PRINT));
            die;
        } catch (\Exception $e) {
            log_message('info', 'Ha ocurrido un error al intentar crear la vista ');
        }
    }

    private function despublicaVista($recurso, $tipoRecurso) {
        try {
            $data = $this->buscaDataEnCatalogo($recurso, $tipoRecurso);
        } catch (\Exception $e) {
            log_message('warning', 'Ha ocurrido un error al intentar despublicar la vista ');
        }
    }
}