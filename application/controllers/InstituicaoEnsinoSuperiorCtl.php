<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';


class InstituicaoEnsinoSuperiorCtl extends API_Controller
{
    public function __construct() {
        parent::__construct();
    }
  
	/**
	 * @api {get} instituicoes-ensino-superior/ Apresentar todas Instituições de Ensino Superior registradas.
	 * @apiName getAll
	 * @apiGroup Instituições de Ensino Superior
	 * @apiSuccess {Number} codIes   Identificador único da Instituição de Ensino Superior.
	 * @apiSuccess {String} nome   Nome da Instituição de Ensino Superior.
	 * @apiSuccess {String} abreviatura  Sigla da Instituição de Ensino Superior.
	 * @apiExample {curl} Exemplo:
	 *     curl -i http://dev.api.ppcchoice.ufes.br/instituicoes-ensino-superior/
	 * @apiSuccessExample {JSON} Success-Response:
	 * HTTP/1.1 200 OK
	 * {
	 *	"status": true,
	 *	"result": [
	 *	{
	*		"codIes": 8,
	*		"nome": "Harvard",
	*		"abreviatura": "HAR"
	 *		},
	 *		{
	 *		"codIes": 573,
	 *		"nome": "Universidade Federal do Espírito Santo",
	 *		"abreviatura": "UFES"
	 *		}
	 *	]
	 * }
	 * @apiError UserNotFound Nenhuma Instituição de Ensino Superior cadastrada.
	 * @apiSampleRequest instituicoes-ensino-superior/
	 * @apiErrorExample {JSON} Error-Response:
	 * HTTP/1.1 404 OK
	 * {
	 *	"status": false,
	 *	"message": "Instituicao de Ensino Superior não encontrada!"
	 * }
	 */
    public function getAll()
    {
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
        $ies = $this->entity_manager->getRepository('Entities\InstituicaoEnsinoSuperior')->findAll(array());
        
        $result = $this->doctrine_to_array($ies,TRUE);

		$this->api_return(array(
			'status' => TRUE,
			'result' => $result,
		), 200);
	}


	/**
	 * @api {get} instituicoes-ensino-superior/:codIes Apresentar dados de uma Instituição de Ensino Superior específica.
	 * @apiName getById
	 * @apiGroup Instituições de Ensino Superior
	 *
	 * @apiParam {Number} codIes Identificador único da Instituição de Ensino Superior requerida.
	 *
	 * @apiSuccess {String} nome   Nome da Instituição de Ensino Superior.
	 * @apiSuccess {String} abreviatura  Sigla da Instituição de Ensino Superior.
	 * @apiExample {curl} Exemplo:
	 *     curl -i http://dev.api.ppcchoice.ufes.br/instituicoes-ensino-superior/573
	 * @apiSuccessExample {JSON} Success-Response:
	 * HTTP/1.1 200 OK
	 * {
	 *	"status": true,
	 *	"result": {
	 *	"codIes": 573,
	 *	"nome": "Universidade Federal do Espírito Santo",
	 *	"abreviatura": "UFES"
	 * }
	 * @apiError UserNotFound O <code>codIes</code> não corresponde a nenhuma Instituição de Ensino Superior cadastrada.
	 * @apiSampleRequest instituicoes-ensino-superior/:codIes
	 * @apiErrorExample {JSON} Error-Response:
	 * HTTP/1.1 404 OK
	 * {
	 *	"status": false,
	 *	"message": "Instituicao de Ensino Superior não encontrada!"
	 * }
	 */
    public function getById($codIes)
    {   
        
        header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
		$ies = $this->entity_manager->find('Entities\InstituicaoEnsinoSuperior',$codIes);
		
		if ( !is_null($ies) ) {
			$result = $this->doctrine_to_array($ies,TRUE);	
			$this->api_return(array(
				'status' => TRUE,
				'result' => $result,
			), 200);
		} else {
			$this->api_return(array(
				'status' => FALSE,
				'message' => 'Instituicao de Ensino Superior não encontrada!',
			), 404);
		}

    }
   
}