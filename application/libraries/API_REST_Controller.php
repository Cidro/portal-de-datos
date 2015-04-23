<?php
require(APPPATH . 'libraries/REST_Controller.php');

class API_REST_Controller extends REST_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('array');
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
     * @return array
     */
    protected function getOrdering($params) {
        $ordering = array();
        $orderParams = explode(',', element('order', $params, 'id'));

        foreach ($orderParams as $orderParam)
            $ordering[ltrim($orderParam, '-')] = (substr($orderParam, 0, 1) == '-') ? 'DESC' : 'ASC';

        return $ordering;
    }
}