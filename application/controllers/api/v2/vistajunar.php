<?php
require(APPPATH . 'libraries/API_REST_Controller.php');

class Vistajunar extends API_REST_Controller {
    public function index_post($guid = null){
        /** @var \Repositories\Recurso $recursos */
        $vistasJunar = $this->doctrine->em->getRepository('Entities\Dataset');
        $recursos = $this->doctrine->em->getRepository('Entities\Recurso');

        $data = $this->post();

        if(is_null($guid)){
            $vistaJunar = new \Entities\VistaJunar();
            $vistaJunar->setCreatedAt(new \DateTime());
            $vistaJunar->setUpdatedAt(new \DateTime());
        } else {
            $vistaJunar = $vistasJunar->findOneBy(array('guid' => $guid));
            $vistaJunar->setUpdatedAt(new \DateTime());
        }

        /** @var \Entities\Recurso $recurso */
        $recurso = $recursos->find(trim(element('recurso_id', $data, null)));
        $dataset = $recurso->getDataset();
        if(!$dataset->esMaestro())
            $dataset = $dataset->getDatasetMaestro();

        $vistaJunar->setRecurso($recurso);
        $vistaJunar->setJunarGuid(trim(element('guid', $data, null)));
        $vistaJunar->setTitle(trim(element('title', $data, null)));
        $vistaJunar->setDescription(trim(element('description', $data, null)));
        $vistaJunar->setCategory(trim(element('category', $data, null)));
        $vistaJunar->setSource(trim(element('source', $data, null)));
        $vistaJunar->setTableId(trim(element('table_id', $data, 0)));
        $vistaJunar->setTags(trim(element('tags', $data, '')));
        $vistaJunar->setMetaData($dataset->getId());

        $errors = $vistaJunar->validate();
        if(empty($errors)){
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