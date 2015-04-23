<?php
require(APPPATH . 'libraries/API_REST_Controller.php');

class Datasets extends API_REST_Controller {

    public function index_post($id = null) {
        /** @var \Repositories\Dataset $datasets */
        /** @var \Repositories\Servicio $servicios */
        /** @var \Doctrine\ORM\EntityRepository $licencias */
        /** @var \Repositories\Categoria $categorias */
        $datasets = $this->doctrine->em->getRepository('Entities\Dataset');
        $servicios = $this->doctrine->em->getRepository('Entities\Servicio');
        $licencias = $this->doctrine->em->getRepository('Entities\Licencia');
        $categorias = $this->doctrine->em->getRepository('Entities\Categoria');

        $data = $this->post();

        if(!element('id', $data)){
            $dataset = new Entities\Dataset();
            $dataset->setMaestro(true);
            $dataset->setPublicado(false);
        } else {
            $dataset = $datasets->find($id);
        }

        $servicio = $servicios->findOneBy(array(
            'codigo' => element('servicio', $data, null)
        ));

        $licencia = $licencias->findOneBy(array(
            'id' => 1
        ));

        $categoria = $categorias->findOneBy(array(
            'id' => element('categoria', $data, null)
        ));

        $dataset->setTitulo(element('titulo', $data, ''));
        $dataset->setDescripcion(element('descripcion', $data, ''));
        $dataset->setServicio($servicio);
        $dataset->setLicencia($licencia);
        if(!is_null($categoria))
            $dataset->addCategoria($categoria);

        $errors = $dataset->validate();

        if(empty($errors)){
            $dataset = $datasets->grabaDataset($dataset);

            $message = is_null($id) ? 'creado': 'actualizado';
            $this->response(array(
                'meta' => array(
                    'error' => false,
                    'messages' => array('El datasets se ha '. $message .' correctamente.'),
                ),
                'item' => $dataset->toArray()
            ));
        }else{
            $this->response(array(
                'meta' => array(
                    'error' => true,
                    'messages' => $errors
                ),
                'item' => null
            ));
        }
    }

    public function find_get($id = null){
        /** @var Repositories\Dataset $datasets */
        /** @var \Entities\Dataset $dataset */
        $datasets = $this->doctrine->em->getRepository('Entities\Dataset');
        $dataset = $datasets->findOneBy(array(
            'id' => $id,
            'maestro' => false,
            'publicado' => true
        ));

        if (is_null($dataset)) {
            $this->response(array(
                'meta' => array(
                    'errors' => true,
                    'messages' => array('No se ha encontrado el dataset')
                )
            ));
        } else {
            $this->response(array(
                'meta' => array(
                    'errors' => false,
                    'messages' => null
                ),
                'item' => $dataset->toArray()
            ));
        }
    }

    public function index_get($id = null){
        $params = $this->get();
        $availableFilters = array(
            'servicio_codigo'
        );
        $forcedFilters = array(
            'maestro' => false,
            'publicado' => true
        );
        /** @var Repositories\Dataset $datasets */
        $datasets = $this->doctrine->em->getRepository('Entities\Dataset');

        $ordering = $this->getOrdering($params);
        $filters = array_merge($this->getFilters($availableFilters, $params), $forcedFilters);

        $limit = intval(element('limit', $params, 10));
        $offset = intval(element('per_page', $params, 0));
        $total = intval($datasets->findWithOrdering(array_merge($filters, array('total' => true)), $ordering, 10));

        $listaDatasets = $datasets->findWithOrdering($filters, $ordering, 10);

        foreach ($listaDatasets as &$dataset) {
            /** @var \Entities\Dataset $dataset */
            $dataset = $dataset->toArray();
        }

        $this->response(array(
            'meta' => array(
                'errors' => false,
                'messages' => null,
                'total' => $total,
                'per_page' => $offset,
                'limit' => $limit
            ),
            'items' => $listaDatasets
        ));
    }
}