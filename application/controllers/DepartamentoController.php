<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class DepartamentoController extends APIController 
{
	public function __construct() {
        parent::__construct();
	}
	
	/**
	 * @api {get} departamentos Solicitar dados de todos Departamentos.
	 * @apiName findAll
	 * @apiGroup Departamento
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiSuccess {Departamento[]} departamento Array de objetos do tipo Departamento.
	 * 
	 * @apiError {String[]} error Entities\\Departamento: Instância não encontrada.
	 */
    public function findAll()
	{
		header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);

		$colecaoDepto = $this->entityManager->getRepository('Entities\Departamento')->findAll();
		
		if ( !empty($colecaoDepto) ){
			$colecaoDepto = $this->doctrineToArray($colecaoDepto,TRUE);	

			$this->apiReturn($colecaoDepto,
				self::HTTP_OK
			);
		} else {
			$this->apiReturn(array(
				'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
				), self::HTTP_NOT_FOUND
			);
		}
	}

	/**
	 * @api {get} departamentos/:codDepto Solicitar dados de um Departamento específico.
	 * @apiName findById
	 * @apiGroup Departamento
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam {Number} codDepto Identificador único do Departamento requerido.
	 *
	 * @apiSuccess {String} nome   Nome do Departamento.
	 * @apiSuccess {String} abreviatura  Sigla do Departamento.
	 * @apiSuccess {Number} codUnidadeEnsino   Identificador único da Unidade de Ensino na qual o Departamento está registrado.
	 * 
	 * @apiError {String[]} error Entities\\Departamento: Instância não encontrada.
	 */
    public function findById($codDepto)
	{
		header("Access-Control-Allow-Origin: *");

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
				'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
				), self::HTTP_NOT_FOUND
			);
		}
    }
    	
	/**
	 * @api {post} departamentos Criar um Departamento.
	 * @apiName create
	 * @apiGroup Departamento
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam (Request Body/JSON) {String} nome   Nome do Departamento.
	 * @apiParam (Request Body/JSON) {String{3..5}} abreviatura  Sigla do Departamento.
	 * @apiParam (Request Body/JSON) {Number} codUnidadeEnsino  Identificador único da Unidade de Ensino.
	 * 
	 * @apiSuccess {String[]} message  Entities\\Departamento: Instância criada com sucesso.
	 *  
	 * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
	 */	
	public function create()
    {
        header("Access-Control-Allow-Origin: *");

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
					'message' => $this->getApiMessage(STD_MSG_CREATED),
					), self::HTTP_OK
				);

			} catch (\Exception $e) {
				$this->apiReturn(array(
					'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
					), self::HTTP_BAD_REQUEST
				);

			}
		} else {
			$this->apiReturn(array(
				'error' => $constraints->messageArray(),
				), self::HTTP_BAD_REQUEST
			);	
		}
	}
	
	/**
     * @api {put} departamentos/:codDepto Atualizar dados de um Departamento.
     * @apiName update
     * @apiGroup Departamento
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam {Number} codDepto Identificador único do Departamento requerido.
	 * 
	 * @apiParam (Request Body/JSON) {String} [nome]   Nome do Departamento.
	 * @apiParam (Request Body/JSON) {String{3..5}} [abreviatura]  Sigla do Departamento.
	 * @apiParam (Request Body/JSON) {Number} [codUnidadeEnsino]  Identificador único da Unidade de Ensino.
	 *  
	 * @apiSuccess {String[]} message Entities\\Departamento: Instância atualizada com sucesso.
	 *  
	 * @apiError {String[]} error Entities\\Departamento: Instância não encontrada.
	 * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
	 */	
	public function update($codDepto)
    {
		header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('PUT'),
			)
		);

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $depto = $this->entityManager->find('Entities\Departamento',$codDepto);
		
        if(!is_null($depto))
        {            
			if(array_key_exists('codUnidadeEnsino', $payload))
            {
				if (is_numeric($payload['codUnidadeEnsino'])){
					$ues = $this->entityManager->find('Entities\UnidadeEnsino',$payload['codUnidadeEnsino']);
					$depto->setUnidadeEnsino($ues);
				}else{
					$depto->setUnidadeEnsino(null);
				}
			}
			
			if ( array_key_exists('nome', $payload) ) $depto->setNome($payload['nome']);
			if ( array_key_exists('abreviatura', $payload) ) $depto->setAbreviatura($payload['abreviatura']);

			$constraints = $this->validator->validate($depto);

			if ( $constraints->success() ){
				try {
					$this->entityManager->merge($depto);
					$this->entityManager->flush();

					$this->apiReturn(array(
						'message' => $this->getApiMessage(STD_MSG_UPDATED),
						), self::HTTP_OK
					);
				} catch (\Exception $e) {
					$this->apiReturn(array(
						'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
						), self::HTTP_BAD_REQUEST
					);
				}	
			} else {
				$this->apiReturn(array(
					'error' => $constraints->messageArray(),
					), self::HTTP_BAD_REQUEST
				);	
			}

        }else{
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
				), self::HTTP_NOT_FOUND
			);
        }
	}
	
	/**
     * @api {delete} departamentos/:codDepto Excluir um Departamento.
     * @apiName delete
     * @apiGroup Departamento
	 * @apiPermission ADMINISTRATOR
	 * 
     * @apiParam {Number} codDepto Identificador único do Departamento.
   	 * 
	 * @apiSuccess {String[]} message  Entities\\Departamento: Instância removida com sucesso.
	 *  
	 * @apiError {String[]} error Entities\\Departamento: Instância não encontrada.
     */
	public function delete($codDepto)
	{
		header("Access-Control-Allow-Origin: *");

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
					'message' => $this->getApiMessage(STD_MSG_DELETED),
					), self::HTTP_OK
				);
				
			} catch (\Exception $e) {
				$this->apiReturn(array(
					'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
					), self::HTTP_BAD_REQUEST
				);
			}
		}else{
			$this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
				), self::HTTP_NOT_FOUND
			);
		}
	}
}