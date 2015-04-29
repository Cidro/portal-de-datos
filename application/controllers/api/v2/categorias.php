<?php

require(APPPATH . 'libraries/API_REST_Controller.php');

class Categorias extends API_REST_Controller {

    /**
     * @var Doctrine
     */
    public $doctrine;

    public function index_get() {
        $params = $this->get();
        /** @var \Repositories\Categoria $categorias */
        $categorias = $this->doctrine->em->getRepository('Entities\Categoria');

        $limit = intval(element('limit', $params, 10));
        $offset = intval(element('offset', $params, 0)) * $limit;
        $ordering = $this->getOrdering($params);

        $total = $categorias->getTotal();
        $categorias = $categorias->findBy(array(), $ordering, $limit, $offset);

        foreach ($categorias as &$categoria) {
            /** @var \Entities\Categoria $categoria */
            $categoria = $categoria->toArray();
        }

        $this->response(array(
            'meta' => array(
                'errors' => false,
                'messages' => null,
                'total' => $total,
                'offset' => $offset,
                'limit' => $limit
            ),
            'items' => $categorias
        ));
    }
}