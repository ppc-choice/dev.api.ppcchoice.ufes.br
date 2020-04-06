<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class CursoCtl extends API_Controller {

    public function getById($codCurso)
	{   
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
		$curso = $this->entity_manager->find('Entities\Curso',$codCurso);
		
		if ( !is_null($curso) ) {
			$result = $this->doctrine_to_array($curso,TRUE);	
			$this->api_return(array(
				'status' => TRUE,
				'result' => $result,
			), 200);
		} else {
			$this->api_return(array(
				'status' => FALSE,
				'message' => 'Curso não encontrado!',
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
		
         /*$qb = $this->entity_manager->createQueryBuilder()
             ->select('curso.codCurso, curso.nome, curso.anoCriacao, unidadeEnsino.nome')
             ->from('Entities\Curso','curso')
             ->leftJoin('curso.unidadeEnsino', 'unidadeEnsino')
             ->getQuery();
        
        $r = $qb->getResult();
        $result = $r;*/

        $curso = $this->entity_manager->getRepository('Entities\Curso')->findBy(array());

        $result = $this->doctrine_to_array($curso,TRUE);

		$this->api_return(array(
			'status' => TRUE,
			'result' => $result,
		), 200);
    }
    
}