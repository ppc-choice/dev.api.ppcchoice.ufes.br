<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class DepartamentoController extends API_Controller {

	/**
	 * @api {get} departamentos/:codDepto Solicitar dados de um Departamento específico.
	 * @apiName findById
	 * @apiGroup Departamentos
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam {Number} codDepto Identificador único do Departamento requerido.
	 *
	 * @apiSuccess {String} nome   Nome do Departamento.
	 * @apiSuccess {String} abreviatura  Sigla do Departamento.
	 * @apiSuccess {Number} codUnidadeEnsino   Identificador único da Unidade de Ensino na qual o Departamento está registrado.
	 * 
	 * @apiError {String[]} 404 O <code>codDepto</code> não corresponde a um Departamento cadastrado.
	 * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
	 * 
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
				'message' => array('Departamento não encontrado!'),
			), self::HTTP_NOT_FOUND);
		}
    }
    

	/**
	 * @api {get} departamentos/ Solicitar dados de todos Departamentos.
	 * @apiName getAll
	 * @apiGroup Departamentos
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiSuccess {departamentos[]} Departamento Array de objetos do tipo Departamentos.
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
	 * @apiName create
	 * @apiGroup Departamentos
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam (Request Body/JSON) {String} nome   Nome do Departamento.
	 * @apiParam (Request Body/JSON) {String} abreviatura  Sigla do Departamento.
	 * @apiParam (Request Body/JSON) {Number} codUnidadeEnsino  Identificador único da Unidade de Ensino.
	 * 
	 * @apiSuccess {String} message  Departamento criado com sucesso.
	 *  
	 * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
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

		if ( array_key_exists('nome', $payload) ) $depto->setNome($payload['nome']);
		if ( array_key_exists('abreviatura', $payload) ) $depto->setAbreviatura($payload['abreviatura']);

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
						'message' => array('Departamento criado com Sucesso!'),
					), self::HTTP_OK);
				} catch (\Exception $e) {
					$mensagem = array($e->getMessage());
					$this->api_return(array(
						'status' => FALSE,
						'message' => $mensagem,
					), self::HTTP_BAD_REQUEST);
				}
			}

	}
	

	/**
     * @api {put} departamentos/:codDepto Atualizar dados de um Departamento.
     * @apiName update
     * @apiGroup Departamentos
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam (Request Body/JSON) {String} nome   Nome do Departamento.
	 * @apiParam (Request Body/JSON) {String} abreviatura  Sigla do Departamento.
	 * @apiParam (Request Body/JSON) {Number} codUnidadeEnsino  Identificador único da Unidade de Ensino.
	 *  
	 * @apiSuccess {String} message  Departamento atualizado com sucesso.
	 *  
	 * @apiError {String[]} 404 O <code>codDepto</code> não corresponde a um Departamento cadastrado.
	 * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
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
			if(isset($payload['codUnidadeEnsino']))
            {
                $ues = $this->entity_manager->find('Entities\UnidadeEnsino',$payload['codUnidadeEnsino']);
				$depto->setUnidadeEnsino($ues);
			}
				if ( array_key_exists('nome', $payload) ) $depto->setNome($payload['nome']);
				if ( array_key_exists('abreviatura', $payload) ) $depto->setAbreviatura($payload['abreviatura']);

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
							'message' => array('Departamento atualizado com sucesso!')
						), self::HTTP_OK);
					} catch (\Exception $e) {
						$e_msg = array($e->getMessage());

						$this->api_return(array(
							'status' => FALSE,
							'message' => $e_msg
						), self::HTTP_BAD_REQUEST);
					}	
				}

        }else{
            $this->api_return(array(
                'status' => FALSE,
                'message' => array('Departamento não encontrado!'),
            ), self::HTTP_NOT_FOUND);
        }
	}
	
	/**
     * @api {delete} departamentos/:codDepto Excluir um Departamento.
     * @apiName delete
     * @apiGroup Departamentos
	 * @apiPermission ADMINISTRATOR
	 * 
     * @apiParam {Number} codDepto Identificador único do Departamento.
   	 * 
	 * @apiSuccess {String} message  Departamento deletado com sucesso.
	 *  
	 * @apiError {String[]} 404 O <code>codDepto</code> não corresponde a uma Departamento cadastrado.
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
					'message' => array('Departamento removido com sucesso!')
				), self::HTTP_OK);
				
			} catch (\Exception $e) {
				$msg = array($e->getMessage());
				$this->api_return(array(
					'status' => FALSE,
					'message' => $msg
				), self::HTTP_BAD_REQUEST);
			}
		}else{
			$this->api_return(array(
                'status' => FALSE,
                'message' => array('Departamento não encontrado!'),
            ), self::HTTP_NOT_FOUND);
		}
	}
}