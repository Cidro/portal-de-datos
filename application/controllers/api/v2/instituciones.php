<?php

require(APPPATH . 'libraries/API_REST_Controller.php');

class Instituciones extends API_REST_Controller {
    /**
     * @var Doctrine
     */
    public $doctrine;

    public function index_get() {
        $params = $this->get();
        /** @var \Repositories\Entidad $entidades */
        $entidades = $this->doctrine->em->getRepository('Entities\Entidad');

        $availableFilters = array(
            'codigo'
        );

        $limit = intval(element('limit', $params, 10));
        $offset = intval(element('offset', $params, 0)) * $limit;
        $ordering = $this->getOrdering($params, 'codigo');
        $filters = $this->getFilters($availableFilters, $params);

        $total = $entidades->getTotal($filters);
        $limit = $limit === 0 ? $total : $limit;
        $entidades = $entidades->findBy($filters, $ordering, $limit, $offset);

        foreach ($entidades as &$entidad) {
            /** @var \Entities\Entidad $entidad */
            $entidad = $entidad->toArray();
        }

        $this->response(array(
            'meta' => array(
                'errors' => false,
                'messages' => null,
                'total' => $total,
                'offset' => $offset,
                'limit' => $limit
            ),
            'items' => $entidades
        ));
    }
}