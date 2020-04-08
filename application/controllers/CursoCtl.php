<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class CursoCtl extends API_Controller {

	/**
	 * @api {get} cursos/:codCurso Apresenta dados de um Curso específico.
	 * @apiName getById
	 * @apiGroup Cursos
	 *
	 * @apiParam {Number} codCurso Identificador único do Curso requerido.
	 *
	 * @apiSuccess {String} nome   Nome do Curso.
	 * @apiSuccess {Number} anoCriacao  Ano em que o curso foi criado.
	 * @apiSuccess {Number} unidadeEnsido   Identificador único da Unidade de Ensino na qual o Curso está registrado.
	 * @apiExample {curl} Exemplo:
	 *     curl -i http://dev.api.ppcchoice.ufes.br/cursos/1
	 * @apiSuccessExample {JSON} Success-Response:
	 * HTTP/1.1 200 OK
	 * {
	 *	"status": true,
	 *	"result": {
	 *	"codCurso": 1,
     *	"nome": "Ciência da Computação",
     *	"anoCriacao": 2011,
     *	"codUnEnsino": 1
	 * }
	 * @apiError UserNotFound O <code>codCurso</code> não corresponde a nenhum Curso cadastrado.
	 * @apiSampleRequest cursos/:codCurso
	 * @apiErrorExample {JSON} Error-Response:
	 * HTTP/1.1 404 OK
	 * {
	 *	"status": false,
	 *	"message": "Curso não encontrado!"
	 * }
	 */
    public function getById($codCurso)
	{   
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
		$curso = $this->entity_manager->find('Entities\Curso',$codCurso);
        $result = $this->doctrine_to_array($curso,TRUE);	
        
		if ( !is_null($curso) ) {
			
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
    
	/**
	 * @api {get} cursos/ Apresentar todos Cursos registrados.
	 * @apiName getAll
	 * @apiGroup Cursos
	 * @apiSuccess {Number} codCurso   Identificador único do curso.
	 * @apiSuccess {String} nome   Nome do curso.
	 * @apiSuccess {Number} anoCriacao  Ano em que o curso foi criado.
	 * @apiSuccess {Number} unidadeEnsido   Identificador único da Unidade de Ensino na qual o Curso está registrado.
	 * @apiExample {curl} Exemplo:
	 *     curl -i http://dev.api.ppcchoice.ufes.br/cursos/
	 * @apiSuccessExample {JSON} Success-Response:
	 * HTTP/1.1 200 OK
	* 
*  "status": true,
*  "result": [
*    {
*      "codCurso": 1,
*      "nomeCurso": "Ciência da Computação",
*      "anoCriacao": 2011,
*      "nomeUnidadeEnsino": "Campus São Mateus",
*      "nomeIes": "Universidade Federal do Espírito Santo"
*    },
*    {
*      "codCurso": 2,
*      "nomeCurso": "Engenharia de Produção",
*      "anoCriacao": 2006,
*      "nomeUnidadeEnsino": "Campus São Mateus",
*      "nomeIes": "Universidade Federal do Espírito Santo"
*    },
*    {
*      "codCurso": 3,
*      "nomeCurso": "Matemática Industrial",
*      "anoCriacao": 2013,
*      "nomeUnidadeEnsino": "Campus São Mateus",
*      "nomeIes": "Universidade Federal do Espírito Santo"
*    }
*  ]
*}

	 * @apiError UserNotFound Nenhum Curso cadastrado.
	 * @apiSampleRequest cursos/
	 * @apiErrorExample {JSON} Error-Response:
	 * HTTP/1.1 404 OK
	 * {
	 *	"status": false,
	 *	"message": "Nenhum Curso cadastrado!"
	 * }
	 */
    public function getAll()
	{   
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);

        $curso = $this->entity_manager->getRepository('Entities\Curso')->getAll();
        $result = $this->doctrine_to_array($curso,TRUE);

		$this->api_return(array(
			'status' => TRUE,
			'result' => $result,
		), 200);
    }
    
}