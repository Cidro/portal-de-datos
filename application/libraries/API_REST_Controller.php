<?php
require(APPPATH . 'libraries/REST_Controller.php');

class API_REST_Controller extends REST_Controller {
    /**
     * @var Doctrine
     */
    public $doctrine;

    /**
     * @var \Repositories\User
     */
    protected $users;

    /**
     * @var \Entities\User
     */
    protected $user;

    function __construct() {
        parent::__construct();
        $this->load->helper('array');

        $this->users = $this->doctrine->em->getRepository('Entities\User');
        $this->user = $this->users->findBy(['api_token' => $this->rest->key]);
    }

    /**
     * Prepara los filtros para consultas a la BD
     * @param $filterNames
     * @param $filterParams
     * @return array
     */
    protected function getFilters($filterNames, $filterParams) {
        $filters = array();
        foreach($filterNames as $filterName)
            if(isset($filterParams[$filterName]))
                $filters[$filterName] = $filterParams[$filterName];
        return $filters;
    }

    /**
     * Prepara los parametros de ordenamiento
     * @param array $params
     * @param string $default
     * @return array
     */
    protected function getOrdering($params, $default = 'id') {
        $ordering = array();
        $orderParams = explode(',', element('order', $params, $default));

        foreach ($orderParams as $orderParam)
            $ordering[ltrim($orderParam, '-')] = (substr($orderParam, 0, 1) == '-') ? 'DESC' : 'ASC';

        return $ordering;
    }
}