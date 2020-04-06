<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class DepartamentoCtl extends API_Controller {

    public function getById($codDepto)
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
		$depto = $this->entity_manager->find('Entities\Departamento',$codDepto);
		
		if ( !is_null($depto) ) {
			$result = $this->doctrine_to_array($depto,TRUE);	
			$this->api_return(array(
				'status' => TRUE,
				'result' => $result,
			), 200);
		} else {
			$this->api_return(array(
				'status' => FALSE,
				'message' => 'Departamento não encontrado!',
			), 404);
		}
    }
    

    public function getAll()
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
        $depto = $this->entity_manager->getRepository('Entities\Departamento')->findAll(array());
        
        $result = $this->doctrine_to_array($depto,TRUE);

		$this->api_return(array(
			'status' => TRUE,
			'result' => $result,
		), 200);
    }
    
}