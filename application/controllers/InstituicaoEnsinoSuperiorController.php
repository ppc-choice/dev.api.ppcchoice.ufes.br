<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class InstituicaoEnsinoSuperiorController extends APIController
{
    public function __construct() {
        parent::__construct();
    }
  
	/**
	 * @api {get} instituicoes-ensino-superior Solicitar dados de todas Instituições de Ensino Superior.
	 * @apiName findAll
	 * @apiGroup Instituição de Ensino Superior
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiSuccess {InstituicaoEnsinoSuperior[]} InstituicaoEnsinoSuperior Array de objetos do tipo InstituicaoEnsinoSuperior.
	 * 
	 * @apiError {String[]} error Entities\\InstituicaoEnsinoSuperior: Instância não encontrada.
	 */
    public function findAll()
    {
		header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
        $colecaoIes = $this->entityManager->getRepository('Entities\InstituicaoEnsinoSuperior')->findAll();
		
		if (!empty($colecaoIes) ){
			$colecaoIes = $this->doctrineToArray($colecaoIes,TRUE);
			$this->apiReturn($colecaoIes,
				self::HTTP_OK
			);
		} else {
			$this->apiReturn(array(
				'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
			), self::HTTP_NOT_FOUND);
		}

	}

	/**
	 * @api {get} instituicoes-ensino-superior/:codIes Solicitar dados de uma Instituição de Ensino Superior.
	 * @apiName findById
	 * @apiGroup Instituição de Ensino Superior
	 * @apiPermission ADMINISTRATOR
	 *
	 * @apiParam {Number} codIes Identificador único da Instituição de Ensino Superior requerida.
	 *
	 * @apiSuccess {String} nome   Nome da Instituição de Ensino Superior.
	 * @apiSuccess {String} abreviatura  Sigla da Instituição de Ensino Superior.
	 * 
	 * @apiError {String[]} error Entities\\InstituicaoEnsinoSuperior: Instância não encontrada.
	 */
    public function findById($codIes)
    {   
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
		$ies = $this->entityManager->find('Entities\InstituicaoEnsinoSuperior',$codIes);
		
		if ( !is_null($ies) ) {
			$ies = $this->doctrineToArray($ies,TRUE);	

			$this->apiReturn($ies,
				self::HTTP_OK
			);
		} else {
			$this->apiReturn(array(
				'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
			), self::HTTP_NOT_FOUND);
		}

	}

	/**
	 * @api {post} instituicoes-ensino-superior Criar uma Instituição de Ensino Superior.
	 * @apiName create
	 * @apiGroup Instituição de Ensino Superior
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam (Request Body/JSON) {Number} codIes   Identificador único da Instituição de Ensino Superior.
	 * @apiParam (Request Body/JSON) {String} nome   Nome da Instituição de Ensino Superior.
	 * @apiParam (Request Body/JSON) {String} abreviatura  Sigla da Instituição de Ensino Superior.
	 * 
	 * @apiSuccess {String[]} message  Entities\\InstituicaoEnsinoSuperior: Instância criada com sucesso.
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
		$ies = new Entities\InstituicaoEnsinoSuperior();

		if ( array_key_exists('codIes', $payload) ) $ies->setCodIes($payload['codIes']);
		if ( array_key_exists('nome', $payload) ) $ies->setNome($payload['nome']);
		if ( array_key_exists('abreviatura', $payload) ) $ies->setAbreviatura($payload['abreviatura']);

		$constraints = $this->validator->validate($ies);

		if ( $constraints->success() ){		
			try {
				$this->entityManager->persist($ies);
				$this->entityManager->flush();
	
				$this->apiReturn(array(
					'result' => $this->getApiMessage(STD_MSG_CREATED),
					), self::HTTP_OK
				);
			} catch (\Exception $e) {
				$this->apiReturn(array(
					'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
					), self::HTTP_BAD_REQUEST
				);
			}	
		}else {
			$this->apiReturn(array(
				'error' => $constraints->messageArray(),
				), self::HTTP_BAD_REQUEST
			);	
		} 
 
    }

	/**
     * @api {put} instituicoes-ensino-superior/:codIes Atualizar dados de uma Instituição de Ensino Superior.
     * @apiName update
     * @apiGroup Instituição de Ensino Superior
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam {Number} codIes Identificador único da Instituição de Ensino Superior.
	 * 
	 * @apiParam (Request Body/JSON) {String} [nome]   Nome da Instituição de Ensino Superior.
	 * @apiParam (Request Body/JSON) {String} [abreviatura]  Sigla da Instituição de Ensino Superior.
	 * 
	 * @apiSuccess {String[]} message Entities\\InstituicaoEnsinoSuperior: Instância atualizada com sucesso.
	 *  
	 * @apiError {String[]} error Entities\\InstituicaoEnsinoSuperior: Instância não encontrada.
	 * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
	 */	
	public function update($codIes)
    {
		header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('PUT'),
            )
		);
		
        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $ies = $this->entityManager->find('Entities\InstituicaoEnsinoSuperior',$codIes);
		
        if(!is_null($ies))
        {            
			if ( array_key_exists('nome', $payload) ) $ies->setNome($payload['nome']);
			if ( array_key_exists('abreviatura', $payload) ) $ies->setAbreviatura($payload['abreviatura']);
			
			$constraints = $this->validator->validate($ies);

			if ( $constraints->success()){
				try {
					$this->entityManager->merge($ies);
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
     * @api {delete} instituicoes-ensino-superior/:codIes Excluir uma Instituição de Ensino Superior.
     * @apiName delete
     * @apiGroup Instituição de Ensino Superior
	 * @apiPermission ADMINISTRATOR
	 * 
     * @apiParam {Number} codIes Identificador único da Instituição de Ensino Superior.
   	 * 
	 * @apiSuccess {String[]} message  Entities\\InstituicaoEnsinoSuperior: Instância removida com sucesso.
	 *  
	 * @apiError {String[]} error Entities\\InstituicaoEnsinoSuperior: Instância não encontrada.
     */
	public function delete($codIes)
	{
		header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('DELETE'),
			)
		);

		$ies = $this->entityManager->find('Entities\InstituicaoEnsinoSuperior',$codIes);
		
		if(!is_null($ies))
		{
			try {
				$this->entityManager->remove($ies);
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