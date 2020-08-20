<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class Welcome extends APIController 
{

	public function index()
	{
		if ( file_exists('documentation') ) {
			redirect('documentation','refresh');
		} else {
			$this->load->view('welcome_message');
		}
	}

	public function updateSchema()
	{
		$folder = 'database/';
		$database = 'ppcchoice';
		$order = array('instituicao_ensino_superior', 
			'unidade_ensino', 
			'curso', 
			'departamento', 
			'disciplina',
			'projeto_pedagogico_curso', 
			'componente_curricular',
			'correspondencia',
			'dependencia',
			'transicao',
			'usuario',
			'api_limit',
			'api_keys');

		try {
			foreach ( $order as $file) 
			{
				$sql = file_get_contents($folder. $database .'_'. $file .'.sql');
				$sqls = explode(';', $sql);
				array_pop($sqls);

				foreach($sqls as $statement){
					$statment = $statement . ";";
					$this->db->query($statement);   
				}
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
		
		echo "Sucess";
	}

	public function getUUID(){

		 $this->apiReturn( array(
			 'uuid' => $this->uniqIdV2()
		 ), self::HTTP_OK );
	}
}
