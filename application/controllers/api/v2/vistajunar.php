<?php
require(APPPATH . 'libraries/API_REST_Controller.php');

class Vistajunar extends API_REST_Controller {
    public function index_post($guid = null){
        /** @var \Repositories\Recurso $recursos */
        /** @var \Repositories\VistaJunar $vistasJunar */
        $vistasJunar = $this->doctrine->em->getRepository('Entities\VistaJunar');
        $recursos = $this->doctrine->em->getRepository('Entities\Recurso');

        $data = $this->post();

        if(is_null($guid)){
            $vistaJunar = new \Entities\VistaJunar();
            $vistaJunar->setCreatedAt(new \DateTime());
            $vistaJunar->setUpdatedAt(new \DateTime());
        } else {
            /** @var \Entities\VistaJunar $vistaJunar */
            $vistaJunar = $vistasJunar->findOneBy(array('junar_guid' => $guid));
            $vistaJunar->setUpdatedAt(new \DateTime());
            $recurso = $vistaJunar->getRecurso();
        }


        if(!isset($recurso)){
            /** @var \Entities\Recurso $recurso */
            $recurso = $recursos->find(trim(element('recurso_id', $data, null)));
            $vistaJunar->setRecurso($recurso);
        }
        if(trim(element('guid', $data, null)))
            $vistaJunar->setJunarGuid(trim(element('guid', $data, null)));
        if(trim(element('title', $data, null)))
            $vistaJunar->setTitle(trim(element('title', $data, null)));
        if(trim(element('description', $data, null)))
            $vistaJunar->setDescription(trim(element('description', $data, null)));
        if(trim(element('category', $data, null)))
            $vistaJunar->setCategory(trim(element('category', $data, null)));
        if(trim(element('source', $data, null)))
            $vistaJunar->setSource(trim(element('source', $data, null)));
        if(!is_null(trim(element('table_id', $data, null))))
            $vistaJunar->setTableId(trim(element('table_id', $data, 0)));
        if(trim(element('tags', $data, '')))
            $vistaJunar->setTags(trim(element('tags', $data, '')));

        $errors = $vistaJunar->validate();
        if(empty($errors)){
            //Se obtiene el dataset asociado al recurso de la vista
            $dataset = $recurso->getDataset();
            if(!$dataset->esMaestro())
                $dataset = $dataset->getDatasetMaestro();
            $vistaJunar->setMetaData($dataset->getId());

            $dataset->setIntegracionJunar(new \DateTime());
            $this->doctrine->em->persist($vistaJunar);
            $this->doctrine->em->persist($dataset);
            $this->doctrine->em->flush();

            $this->response(array(
                'meta' => array(
                    'error' => false,
                    'messages' => array('La vista de Junar se ha ' . (is_null($guid) ? 'creado' : 'actualizado') . ' correctamente.'),
                ),
                'item' => $vistaJunar->toArray(true)
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

    public function update_post($guid){
        $this->index_post($guid);
    }
}