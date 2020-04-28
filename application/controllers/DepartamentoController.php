<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class DepartamentoController extends API_Controller {

	/**
	 * @api {get} departamentos/:codDepto Requisitar dados de um Departamento específico.
	 * @apiName findById
	 * @apiGroup Departamentos
	 *
	 * @apiParam {Number} codDepto Identificador único do Departamento requerido.
	 *
	 * @apiSuccess {String} nome   Nome do Departamento.
	 * @apiSuccess {String} abreviatura  Sigla do Departamento.
	 * @apiSuccess {Number} unidadeEnsino   Identificador único da Unidade de Ensino na qual o Departamento está registrado.
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
	 * @apiError DepartamentoNotFound O <code>codDepto</code> não corresponde a nenhum Departamento cadastrado.
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
			), self::HTTP_OK);
		} else {
			$this->api_return(array(
				'status' => FALSE,
				'message' => 'Departamento não encontrado!',
			), self::HTTP_NOT_FOUND);
		}
    }
    

	/**
	 * @api {get} departamentos/ Requisitar todos Departamentos registrados.
	 * @apiName findAll
	 * @apiGroup Departamentos
	 * @apiSuccess {String} nome   Nome da Departamento.
	 * @apiSuccess {String} abreviatura  Sigla da Departamento.
	 * @apiSuccess {Number} unidadeEnsino   Identificador único da Unidade de Ensino na qual o Departamento está registrado.
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
	* ...,
	* 	{
	* 		"codDepto": 6,
	* 		"nome": "Departamento Não Especificado",
	* 		"abreviatura": "DNE",
	*		"nomeUnidadeEnsino": "Campus São Mateus"
	* 	}
	* 	]
	* }

	 * @apiError DepartamentoNotFound Nenhum Departamento cadastrado.
	 * @apiSampleRequest departamentos/
	 * @apiErrorExample {JSON} Error-Response:
	 * HTTP/1.1 404 OK
	 * {
	 *	"status": false,
	 *	"message": "Nenhum Departamento cadastrado!"
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
		), self::HTTP_OK);
	}
	
	/**
	 * @api {post} departamentos/ Criar um Departamento.
	 * @apiName add
	 * @apiGroup Departamentos
	 * @apiSuccess {Number} codDepto   Identificador único auto incrementável do Departamento.
	 * @apiSuccess {String} nome   Nome da Departamento.
	 * @apiSuccess {String} abreviatura  Sigla da Departamento.
	 * @apiSuccess {Number} unidadeEnsino   Identificador único da Unidade de Ensino na qual o Departamento está registrado.
	 * @apiExample {curl} Exemplo:
	 *     curl -i http://dev.api.ppcchoice.ufes.br/departamentos/
	 * @apiParamExample {json} Request-Example:
     * {
     *   "nome": "Novo Departamento",
     *	 "unidadeEnsino": 1,
     *	 "abreviatura": "DNOVO"
     * }
	 * @apiSuccessExample {JSON} Success-Response:
	 * HTTP/1.1 200 OK
	* {
	* 	"status": true,
	* 	"result": "Departamento criado com Sucesso!"
	* {
	
	 * @apiError DepartamentoNotFound Não foi possível criar um novo cadastro de departamento.
	 * @apiSampleRequest departamentos/
	 * @apiErrorExample {JSON} Error-Response:
	 * HTTP/1.1 404 OK
	 * {
	 *	"status": false,
	 *	"message": "Campo Obrigatorio Não Encontrado!"
	 * }
	 */
	public function create()
    {
        header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('POST'),
			)
		);
 
		$payload = json_decode(file_get_contents('php://input'),TRUE);
		
		$depto = new \Entities\Departamento;

		if ( isset($payload['nome']) ) $depto->setNome($payload['nome']);
		if ( isset($payload['abreviatura']) ) $depto->setAbreviatura($payload['abreviatura']);

        if (isset($payload['codUnidadeEnsino'])){
			$ues = $this->entity_manager->find('Entities\UnidadeEnsino', $payload['codUnidadeEnsino']);
			$depto->setUnidadeEnsino($ues);
		}

			$validacao = $this->validator->validate($depto);

			if ( $validacao->count() ){		
				$msg = $validacao->messageArray();
	
				$this->api_return(array(
					'status' => FALSE,
					'message' => $msg,
				), self::HTTP_BAD_REQUEST);	
			} else {
				try {
					$this->entity_manager->persist($depto);
					$this->entity_manager->flush();
		
					$this->api_return(array(
						'status' => TRUE,
						'message' => 'Departamento criado com Sucesso!',
					), self::HTTP_OK);
				} catch (\Exception $e) {
					$mensagem = $e->getMessage();
					$this->api_return(array(
						'status' => FALSE,
						'message' => $mensagem,
					), self::HTTP_BAD_REQUEST);
				}
			}

	}
	

	/**
     * @api {put} departamentos/:codDepto Atualizar Departamento.
     * @apiName update
     * @apiGroup Departamentos
     * @apiParam {Number} codDepto Código do Departamento.
     * @apiError  (Campo obrigatorio não encontrado 400) BadRequest Algum campo obrigatório não foi inserido.
     * @apiError  (Departamento não encontrado 404) Departamento não encontrado.
     * @apiParamExample {json} Request-Example:
     *     {
     *         "nome" : "Departamento de Ciência de Dados",
	 *         "abreviatura" : "DCD",
	 *         "unidadeEnsino" : 1
     *     }
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Departamento atualizado com sucesso"
     *     }
     */
	public function update($codDepto)
    {
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('PUT'),
			)
		);

        $depto = $this->entity_manager->find('Entities\Departamento',$codDepto);
        $payload = json_decode(file_get_contents('php://input'),TRUE);
		
        if(!is_null($depto))
        {            
			if(isset($payload['codUnidadeEnsino'])) //Verificar resultados de isset e is_null
            {
                $ues = $this->entity_manager->find('Entities\UnidadeEnsino',$payload['codUnidadeEnsino']);
				$depto->setUnidadeEnsino($ues);
			}

				if(isset($payload['nome'])) $depto->setNome($payload['nome']);
				if(isset($payload['abreviatura'])) $depto->setAbreviatura($payload['abreviatura']);

				$valida = $this->validator->validate($depto);

				if ( $valida->count() ){
					$msg = $valida->messageArray();
		
					$this->api_return(array(
						'status' => FALSE,
						'message' => $msg,
					), self::HTTP_BAD_REQUEST);	
				} else {
					try {
						$this->entity_manager->merge($depto);
						$this->entity_manager->flush();
						$this->api_return(array(
							'status' => TRUE,
							'message' => 'Departamento atualizado com sucesso!'
						), self::HTTP_OK);
					} catch (\Exception $e) {
						$e_msg = $e->getMessage();
						$this->api_return(array(
							'status' => FALSE,
							'message' => $e_msg
						), self::HTTP_BAD_REQUEST);
					}	
				}

        }elseif(empty($payload))
        {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Corpo da Requisição vazio',
            ), self::HTTP_BAD_REQUEST);
        }else{
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Departamento não encontrado!',
            ), self::HTTP_NOT_FOUND);
        }
	}
	
	/**
     * @api {delete} departamentos/:codDepto Deletar Departamento.
     * @apiName delete
     * @apiGroup Departamentos
     * @apiParam {Number} codDepto Código do Departamento.
     * @apiError  (Campo não encontrado self::HTTP_BAD_REQUEST) NotFound Departamento não encontrado.
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Departamento removido com sucesso"
     *     }
     */
	public function delete($codDepto)
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('DELETE'),
			)
		);

		$depto = $this->entity_manager->find('Entities\Departamento',$codDepto);
		
		if(!is_null($depto))
		{
			try {
				$this->entity_manager->remove($depto);
				$this->entity_manager->flush();
				$this->api_return(array(
					'status' => TRUE,
					'message' => 'Departamento removido com sucesso!'
				), self::HTTP_OK);
				
			} catch (\Exception $e) {
				$msg = $e->getMessage();
				$this->api_return(array(
					'status' => FALSE,
					'message' => $msg
				), self::HTTP_BAD_REQUEST);
			}
		}else{
			$this->api_return(array(
                'status' => FALSE,
                'message' => 'Departamento não encontrado!',
            ), self::HTTP_NOT_FOUND);
		}
	}
}