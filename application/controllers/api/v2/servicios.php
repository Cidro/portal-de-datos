<?php

require(APPPATH . 'libraries/API_REST_Controller.php');

class Servicios extends API_REST_Controller {

    /**
     * @var Doctrine
     */
    public $doctrine;

    public function index_get() {
        $params = $this->get();
        /** @var \Repositories\Servicio $servicios */
        $servicios = $this->doctrine->em->getRepository('Entities\Servicio');

        $availableFilters = array(
            'codigo',
            'entidad_codigo'
        );

        $forcedFilters = array(
            'publicado' => true,
            'oficial' => true,
            'codigo_servicio_oficial' => null
        );

        $limit = intval(element('limit', $params, 10));
        $offset = intval(element('offset', $params, 0)) * $limit;
        $ordering = $this->getOrdering($params, 'codigo');
        $filters = array_merge($this->getFilters($availableFilters, $params), $forcedFilters);

        $total = $servicios->getTotal($filters);
        $limit = $limit === 0 ? $total : $limit;
        $servicios = $servicios->findBy($filters, $ordering, $limit, $offset);

        foreach ($servicios as &$servicio) {
            /** @var \Entities\Servicio $servicio */
            $servicio = $servicio->toArray();
        }

        $this->response(array(
            'meta' => array(
                'errors' => false,
                'messages' => null,
                'total' => $total,
                'offset' => $offset,
                'limit' => $limit
            ),
            'items' => $servicios
        ));
    }
}