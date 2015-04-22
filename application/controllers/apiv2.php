<?php
require(APPPATH . 'libraries/REST_Controller.php');

class Apiv2 extends REST_Controller {


    function __construct() {
        parent::__construct();
        $this->load->helper('array');
    }

    public function datasets_get($id = null) {
        /** @var \Repositories\Dataset $datasets */
        /** @var \Repositories\Servicio $servicios */
        /** @var \Doctrine\ORM\EntityRepository $licencias */
        /** @var \Repositories\Categoria $categorias */
        $datasets = $this->doctrine->em->getRepository('Entities\Dataset');
        $servicios = $this->doctrine->em->getRepository('Entities\Servicio');
        $licencias = $this->doctrine->em->getRepository('Entities\Licencia');
        $categorias = $this->doctrine->em->getRepository('Entities\Categoria');

        $data = $this->get();

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
        $dataset->addCategoria($categoria);

        $errors = $dataset->validate();

        if(empty($errors)){
            $dataset = $datasets->grabaDataset($dataset);

            echo json_encode($dataset->toArray());
        }else{
            echo json_encode(array(
                'error' => true,
                'message' => $errors
            ));
        }
    }

    public function servicios_get(){
        /** @var \Repositories\Servicio $servicios */
        $servicios = $this->doctrine->em->getRepository('Entities\Servicio');

        $servicios = $servicios->findBy([
            'publicado' => true,
            'oficial' => true,
            'codigo_servicio_oficial' => null
        ]);

        foreach($servicios as &$servicio){
            /** @var \Entities\Servicio $servicio */
            $servicio = $servicio->toArray();
        }

        echo json_encode($servicios);
    }

    public function categorias_get(){
        /** @var \Repositories\Categoria $categorias */
        $categorias = $this->doctrine->em->getRepository('Entities\Categoria');

        $categorias = $categorias->findAll();

        foreach($categorias as &$categoria){
            /** @var \Entities\Categoria $categoria */
            $categoria = $categoria->toArray();
        }

        echo json_encode($categorias);
    }
}