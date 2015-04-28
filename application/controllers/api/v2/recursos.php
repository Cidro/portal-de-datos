<?php
require(APPPATH . 'libraries/API_REST_Controller.php');

class Recursos extends API_REST_Controller {
    public function index_post($id = null) {
        /** @var \Repositories\Dataset $datasets */
        /** @var \Repositories\Recurso $recursos */
        $datasets = $this->doctrine->em->getRepository('Entities\Dataset');
        $recursos = $this->doctrine->em->getRepository('Entities\Recurso');

        $data = $this->post();

        if(is_null($id)){
            $dataset = $datasets->find(trim(element('dataset_id', $data, null)));
            $recurso = new \Entities\Recurso();
            $recurso->setDataset($dataset);
        } else {
            $recurso = $recursos->find($id);
        }

        $recurso->setDescripcion(trim(element('descripcion', $data, null)));
        $recurso->setUrl(trim(element('url', $data, null)));
        $recurso->setMime(trim(element('mime', $data, null)));
        $recurso->setSize(trim(element('size', $data, null)));

        $result = $recursos->grabaRecurso($recurso);
        if(!is_array($result)){
            $recurso = $result;
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
                    'messages' => $result
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