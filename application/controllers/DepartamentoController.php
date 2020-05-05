<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class DepartamentoController extends APIController 
{
	public function __construct() {
        parent::__construct();
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

		$colecaoDepto = $this->entityManager->getRepository('Entities\Departamento')->findAll();
		$colecaoDepto = $this->doctrineToArray($colecaoDepto,TRUE);	

		$this->apiReturn($colecaoDepto,
			self::HTTP_OK
		);
	}

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
		
		$depto = $this->entityManager->find('Entities\Departamento',$codDepto);
		
		if ( !is_null($depto) ) {
			$depto = $this->doctrineToArray($depto,TRUE);	

			$this->apiReturn($depto,
				self::HTTP_OK
			);
		} else {
			$this->apiReturn(array(
				'error' => array('Departamento não encontrado!'),
				), self::HTTP_NOT_FOUND
			);
		}
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
		$depto = new Entities\Departamento();

		if ( array_key_exists('nome', $payload) ) $depto->setNome($payload['nome']);
		if ( array_key_exists('abreviatura', $payload) ) $depto->setAbreviatura($payload['abreviatura']);

        if (isset($payload['codUnidadeEnsino'])){
			$ues = $this->entityManager->find('Entities\UnidadeEnsino', $payload['codUnidadeEnsino']);
			$depto->setUnidadeEnsino($ues);
		}

		$constraints = $this->validator->validate($depto);

		if ( $constraints->success() ){		
			try {
				$this->entityManager->persist($depto);
				$this->entityManager->flush();
	
				$this->apiReturn(array(
					'message' => array('Departamento criado com Sucesso!'),
					), self::HTTP_OK
				);

			} catch (\Exception $e) {
				$msgExcecao = array($e->getMessage());

				$this->apiReturn(array(
					'error' => $msgExcecao,
					), self::HTTP_BAD_REQUEST
				);

			}
		} else {
			$msgViolacoes = $constraints->messageArray();
			
			$this->apiReturn(array(
				'error' => $msgViolacoes,
				), self::HTTP_BAD_REQUEST
			);	
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

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $depto = $this->entityManager->find('Entities\Departamento',$codDepto);
		
        if(!is_null($depto))
        {            
			if(isset($payload['codUnidadeEnsino']))
            {
                $ues = $this->entityManager->find('Entities\UnidadeEnsino',$payload['codUnidadeEnsino']);
				$depto->setUnidadeEnsino($ues);
			}
			
			if ( array_key_exists('nome', $payload) ) $depto->setNome($payload['nome']);
			if ( array_key_exists('abreviatura', $payload) ) $depto->setAbreviatura($payload['abreviatura']);

			$constraints = $this->validator->validate($depto, null, array('Departamento'));

			if ( $constraints->success() ){
				try {
					$this->entityManager->merge($depto);
					$this->entityManager->flush();

					$this->apiReturn(array(
						'message' => array('Departamento atualizado com sucesso!')
						), self::HTTP_OK
					);
				} catch (\Exception $e) {
					$msgExcecao = array($e->getMessage());
					
					$this->apiReturn(array(
						'error' => $msgExcecao
						), self::HTTP_BAD_REQUEST
					);
				}	
			} else {
				$msgViolacoes = $constraints->messageArray();
	
				$this->apiReturn(array(
					'error' => $msgViolacoes,
					), self::HTTP_BAD_REQUEST
				);	
			}

        }else{
            $this->apiReturn(array(
                'error' => array('Departamento não encontrado!'),
				), self::HTTP_NOT_FOUND
			);
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

		$depto = $this->entityManager->find('Entities\Departamento',$codDepto);
		
		if(!is_null($depto))
		{
			try {
				$this->entityManager->remove($depto);
				$this->entityManager->flush();
				
				$this->apiReturn(array(
					'message' => array('Departamento removido com sucesso!')
					), self::HTTP_OK
				);
				
			} catch (\Exception $e) {
				$msgExcecao = array($e->getMessage());
				
				$this->apiReturn(array(
					'error' => $msgExcecao
					), self::HTTP_BAD_REQUEST
				);
			}
		}else{
			$this->apiReturn(array(
                'error' => array('Departamento não encontrado!'),
				), self::HTTP_NOT_FOUND
			);
		}
	}
}