<?php
require(APPPATH . 'libraries/API_REST_Controller.php');

class Datasets extends API_REST_Controller {

    /**
     * Crea un nuevo dataset en el catalogo
     * @param int $id
     */
    public function index_post($id = null) {
        /** @var \Repositories\Dataset $datasets */
        /** @var \Repositories\Servicio $servicios */
        /** @var \Doctrine\ORM\EntityRepository $licencias */
        /** @var \Repositories\Categoria $repoCategorias */
        $datasets = $this->doctrine->em->getRepository('Entities\Dataset');
        $servicios = $this->doctrine->em->getRepository('Entities\Servicio');
        $licencias = $this->doctrine->em->getRepository('Entities\Licencia');
        $repoCategorias = $this->doctrine->em->getRepository('Entities\Categoria');

        /** @var \Entities\User $user */
        $user = $this->user[0];

        $data = $this->post();

        if(is_null($id)){
            $dataset = new Entities\Dataset();
            $dataset->setMaestro(true);
            $dataset->setPublicado(false);
        } else {
            /** @var \Entities\Dataset $dataset */
            $dataset = $datasets->find($id);
        }

        $servicio = $servicios->findOneBy(array(
            'codigo' => trim(element('servicio', $data, null))
        ));

        $licencia = $licencias->findOneBy(array(
            'id' => 1
        ));

        $categorias = $repoCategorias->findBy(array(
            'id' => explode(',', trim(element('categoria', $data, '')))
        ));

        $dataset->setTagsByCsv(element('tags', $data, ''));

        $dataset->setCoordenadas(trim(element('coordenadas', $data, '')));

        $dataset->setFrecuencia(trim(element('frecuencia', $data, '')));

        $dataset->setGranularidad(trim(element('granularidad', $data, '')));

        $dataset->setCoberturaTemporal(trim(element('cobertura_temporal', $data, '')));

        if(trim(element('titulo', $data, '')))
            $dataset->setTitulo(trim(element('titulo', $data, '')));

        if(trim(element('descripcion', $data, '')))
            $dataset->setDescripcion(trim(element('descripcion', $data, '')));

        if(!is_null($servicio))
            $dataset->setServicio($servicio);
        if(!is_null($licencia))
            $dataset->setLicencia($licencia);

        foreach($categorias as $categoria)
            $dataset->addCategoria($categoria);

        $errors = $dataset->validate();

        //Solo se deben actualizar datasets maestros
        if(!$dataset->esMaestro())
            $errors[] = 'Dataset inválido para actualización';

        if(!$servicio)
            $errors[] = 'No se ha encontrado el servicio con codigo: ' . element('servicio', $data, null);

        if($servicio && !$user->hasAccessToDataset($dataset, 'ingreso'))
            $errors[] = 'No se tiene acceso a la creación de datasets';

        if(empty($errors)){
            $dataset = $datasets->grabaDataset($dataset);

            $message = is_null($id) ? 'creado': 'actualizado';
            $this->response(array(
                'meta' => array(
                    'error' => false,
                    'messages' => array('El dataset se ha '. $message .' correctamente.'),
                ),
                'item' => $dataset->toArray(true)
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

    /**
     * Actualiza un dataset del catalogo
     * @param int $id
     */
    public function update_post($id = null){
        $this->index_post($id);
    }

    /**
     * Obtiene un dataset desde el catalogo
     * @param int $id
     */
    public function update_get($id = null){
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
            ), 404);
        } else {
            $this->response(array(
                'meta' => array(
                    'errors' => false,
                    'messages' => null
                ),
                'item' => $dataset->toArray(true)
            ));
        }
    }

    /**
     * Obtiene un listado de datasets
     */
    public function index_get(){
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

        $ordering = $this->getOrdering($params, 'maestro_id');
        $filters = array_merge($this->getFilters($availableFilters, $params), $forcedFilters);

        $limit = intval(element('limit', $params, 10));
        $offset = intval(element('offset', $params, 0)) * $limit;
        $total = intval($datasets->findWithOrdering(array_merge($filters, array('total' => true)), $ordering));

        $limit = $limit === 0 ? $total : $limit;

        $listaDatasets = $datasets->findWithOrdering($filters, $ordering, $limit, $offset);

        foreach ($listaDatasets as &$dataset) {
            /** @var \Entities\Dataset $dataset */
            $dataset = $dataset->toArray(true);
        }

        $this->response(array(
            'meta' => array(
                'errors' => false,
                'messages' => null,
                'total' => $total,
                'offset' => $offset,
                'limit' => $limit
            ),
            'items' => $listaDatasets
        ));
    }
}