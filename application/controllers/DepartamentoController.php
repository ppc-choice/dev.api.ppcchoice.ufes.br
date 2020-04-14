<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class DepartamentoController extends API_Controller {

	/**
	 * @api {get} departamentos/:codDepto Apresenta dados de um Departamento específico.
	 * @apiName findById
	 * @apiGroup Departamentos
	 *
	 * @apiParam {Number} codDepto Identificador único do Departamento requerido.
	 *
	 * @apiSuccess {String} nome   Nome do Departamento.
	 * @apiSuccess {String} abreviatura  Sigla do Departamento.
	 * @apiSuccess {Number} unidadeEnsido   Identificador único da Unidade de Ensino na qual o Departamento está registrado.
	 * @apiExample {curl} Exemplo:
	 *     curl -i http://dev.api.ppcchoice.ufes.br/departamentos/1
	 * @apiSuccessExample {JSON} Success-Response:
	 * HTTP/1.1 200 OK
	 * {
	 *	"status": true,
	 *	"result": {
	 *	"codDepto": 1,
	 *	"nome": "Departamento de Computação e Eletrônica",
	 *	"abreviatura": "DCE",
	 *	"nomeUnidadeEnsino": "Campus São Mateus"
	 * }
	 * @apiError UserNotFound O <code>codDepto</code> não corresponde a nenhum Departamento cadastrado.
	 * @apiSampleRequest departamentos/:codDepto
	 * @apiErrorExample {JSON} Error-Response:
	 * HTTP/1.1 404 OK
	 * {
	 *	"status": false,
	 *	"message": "Departamento não encontrado!"
	 * }
	 */
    public function findById($codDepto)
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
    

	/**
	 * @api {get} departamentos/ Apresentar todos Departamentos registrados.
	 * @apiName findAll
	 * @apiGroup Departamentos
	 * @apiSuccess {Number} codDepto   Identificador único da Departamento.
	 * @apiSuccess {String} nome   Nome da Departamento.
	 * @apiSuccess {String} abreviatura  Sigla da Departamento.
	 * @apiSuccess {Number} unidadeEnsido   Identificador único da Unidade de Ensino na qual o Departamento está registrado.
	 * @apiExample {curl} Exemplo:
	 *     curl -i http://dev.api.ppcchoice.ufes.br/departamentos/
	 * @apiSuccessExample {JSON} Success-Response:
	 * HTTP/1.1 200 OK
	* {
	* 	"status": true,
	* 	"result": [
	* 	{
	* 		"codDepto": 1,
	* 		"nome": "Departamento de Computação e Eletrônica",
	* 		"abreviatura": "DCE",
	*		"nomeUnidadeEnsino": "Campus São Mateus"
	* 	},
	* 	{
	* 		"codDepto": 2,
	* 		"nome": "Departamento de Matemática Aplicada",
	* 		"abreviatura": "DMA",
	*		"nomeUnidadeEnsino": "Campus São Mateus"
	*	},
	* 	{
	* 		"codDepto": 3,
	* 		"nome": "Departamento de Ciências Naturais",
	* 		"abreviatura": "DCN",
	*		"nomeUnidadeEnsino": "Campus São Mateus"
	* 	},
	* 	{
	* 		"codDepto": 4,
	* 		"nome": "Departamento de Engenharias  e Tecnologias",
	* 		"abreviatura": "DET",
	*		"nomeUnidadeEnsino": "Campus São Mateus"
	* 	},
	* 	{
	* 		"codDepto": 5,
	* 		"nome": "Departamento de Educação e Ciências Humanas",
	* 		"abreviatura": "ECH",
	*		"nomeUnidadeEnsino": "Campus São Mateus"
	* 	},
	* 	{
	* 		"codDepto": 6,
	* 		"nome": "Departamento Não Especificado",
	* 		"abreviatura": "DNE",
	*		"nomeUnidadeEnsino": "Campus São Mateus"
	* 	}
	* 	]
	* }

	 * @apiError UserNotFound Nenhuma Departamento cadastrado.
	 * @apiSampleRequest departamentos/
	 * @apiErrorExample {JSON} Error-Response:
	 * HTTP/1.1 404 OK
	 * {
	 *	"status": false,
	 *	"message": "Nenhuma Departamento cadastrado!"
	 * }
	 */
    public function findAll()
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);

		$depto = $this->entity_manager->getRepository('Entities\Departamento')->findAll();
		$result = $this->doctrine_to_array($depto,TRUE);	


		$this->api_return(array(
			'status' => TRUE,
			'result' => $result,
		), 200);
	}
	

	public function add()
    {
        $this->_apiConfig(array(
            'methods' => array('POST'),
            // 'limit' => array(2,'ip','everyday'),
            // 'requireAuthorization' => TRUE
            )
        );
 
        $payload = json_decode(file_get_contents('php://input'),TRUE);
 
        if ( isset($payload['nome']) && isset($payload['unidadeEnsino']) && isset($payload['abreviatura'])){
           
			$depto = new \Entities\Departamento;
			//$depto->setCodDepto($payload['codDepto']);
            //$depto->setUnidadeEnsino($payload['unidadeEnsino']);
            $depto->setNome($payload['nome']);
			$depto->setAbreviatura($payload['abreviatura']);
			
			$ues = $this->entity_manager->find('Entities\UnidadeEnsino', $payload['unidadeEnsino']);

			if (!is_null($ues)){
				$depto->setUnidadeEnsino($ues);
			}
           
            try {
                $this->entity_manager->persist($depto);
                $this->entity_manager->flush();
 
                $this->api_return(array(
                    'status' => TRUE,
                    'result' => 'Departamento criado com Sucesso!',
                ), 200);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
 
        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Campo Obrigatorio Não Encontrado!',
            ), 400);
        }
    }
    
}