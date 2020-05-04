<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class Welcome extends APIController {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function updateSchema()
	{
		$folder = 'database/';
		$database = 'bancoppc';
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

}
