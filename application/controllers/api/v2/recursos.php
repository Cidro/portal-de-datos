<?php
require(APPPATH . 'libraries/API_REST_Controller.php');

class Recursos extends API_REST_Controller {
    public function index_post($id = null) {
        /** @var \Repositories\Dataset $datasets */
        /** @var \Repositories\Recurso $recursos */
        $datasets = $this->doctrine->em->getRepository('Entities\Dataset');
        $recursos = $this->doctrine->em->getRepository('Entities\Recurso');

        $data = $this->post();

        /** @var \Entities\Dataset $datasets */
        $dataset = $datasets->find(trim(element('dataset_id', $data, null)));

        if(is_null($id)){
            $recurso = new \Entities\Recurso();
            $recurso->setDataset($dataset);
        } else {
            $recurso = $recursos->find($id);
        }

        if(trim(element('descripcion', $data, null)))
            $recurso->setDescripcion(trim(element('descripcion', $data, null)));

        if(trim(element('url', $data, null)))
            $recurso->setUrl(trim(element('url', $data, null)));

        if(trim(element('mime', $data, null)))
            $recurso->setMime(trim(element('mime', $data, null)));

        if(trim(element('size', $data, null)))
            $recurso->setSize(trim(element('size', $data, null)));

        $errors = $recurso->validate();

        if(!$dataset)
            $errors[] = 'No existe el dataset para asociar el recurso.';

        if(!$this->user->hasAccessToDataset($dataset, 'ingreso'))
            $errors[] = 'No se tiene acceso a la creación de recursos para este dataset';

        if(empty($errors)){
            $recurso = $recursos->grabaRecurso($recurso);
            $this->response(array(
                'meta' => array(
                    'error' => false,
                    'messages' => array('El recurso se ha ' . (is_null($id) ? 'creado' : 'actualizado') . ' correctamente.'),
                ),
                'item' => $recurso->toArray(true)
            ));
        } else {
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
     * Actualiza un recurso
     * @param $id
     */
    public function update_post($id){
        //Por simplicidad utilizamos el mismo metodo que para la creación
        $this->index_post($id);
    }
}