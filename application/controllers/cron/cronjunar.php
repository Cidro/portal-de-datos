<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjunar extends CI_Controller {

    /**
     * @var Junar
     */
    public $junar;

    function __construct() {
        parent::__construct();
        if(!$this->input->is_cli_request())
            return show_404();
        $this->load->library('Junar');
    }

    public function sync(){
        //Obtiene la ultima fecha de actualización desde Junar
        $ultimaActualizacion = new DateTime();

        //Consulta a Junar por los cambios desde la última fecha
        $cambios = $this->junar->ultimosCambios($ultimaActualizacion);

        //Se debe recorer el lisado de cambios y aplicarlos donde corresponda

        
    }
}