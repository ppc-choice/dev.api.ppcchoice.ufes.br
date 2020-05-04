<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class InstituicaoEnsinoSuperiorController extends APIController
{
    public function __construct() {
        parent::__construct();
    }
  
	/**
	 * @api {get} instituicoes-ensino-superior/ Solicitar dados de todas Instituições de Ensino Superior.
	 * @apiName getAll
	 * @apiGroup Instituições de Ensino Superior
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiSuccess {InstituicaoEnsinoSuperior[]} InstituicoesEnsinoSuperior Array de objetos do tipo InstituicaoEnsinoSuperior.
	 */
    public function getAll()
    {
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
        $colecaoIes = $this->entityManager->getRepository('Entities\InstituicaoEnsinoSuperior')->findAll();
        $colecaoIes = $this->doctrineToArray($colecaoIes,TRUE);

		$this->apiReturn($colecaoIes,
			self::HTTP_OK
		);
	}

	/**
	 * @api {get} instituicoes-ensino-superior/:codIes Solicitar dados de uma Instituição de Ensino Superior.
	 * @apiName getById
	 * @apiGroup Instituições de Ensino Superior
	 * @apiPermission ADMINISTRATOR
	 *
	 * @apiParam {Number} codIes Identificador único da Instituição de Ensino Superior requerida.
	 *
	 * @apiSuccess {String} nome   Nome da Instituição de Ensino Superior.
	 * @apiSuccess {String} abreviatura  Sigla da Instituição de Ensino Superior.
	 * 
	 * @apiError {String[]} 404 O <code>codIes</code> não corresponde a uma Instituição de Ensino Superior cadastrada.
	 * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
	 */
    public function getById($codIes)
    {   
        header("Access-Controll-Allow-Origin: *");

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
				'error' => array('Instituicao de Ensino Superior não encontrada!'),
			), self::HTTP_NOT_FOUND);
		}

	}
	

	/**
	 * @api {post} instituicoes-ensino-superior/ Criar uma Instituição de Ensino Superior.
	 * @apiName create
	 * @apiGroup Instituições de Ensino Superior
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam (Request Body/JSON) {Number} codIes   Identificador único da Instituição de Ensino Superior.
	 * @apiParam (Request Body/JSON) {String} nome   Nome da Instituição de Ensino Superior.
	 * @apiParam (Request Body/JSON) {String} abreviatura  Sigla da Instituição de Ensino Superior.
	 * 
	 * @apiSuccess {String} message  Instituição de Ensino Superior criada com sucesso.
	 *  
	 * @apiError {String[]} 404 O <code>codIes</code> não corresponde a uma Instituição de Ensino Superior cadastrada.
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
					'result' => array('Instituicao de Ensino Superior Criada com Sucesso!'),
					), self::HTTP_OK
				);
			} catch (\Exception $e) {
				$msgExcecao = array($e->getMessage());
				
				$this->apiReturn(array(
					'error' => $msgExcecao,
					), self::HTTP_BAD_REQUEST
				);
			}	
		}else {
			$msgViolacoes = $constraints->messageArray();

			$this->apiReturn(array(
				'error' => $msgViolacoes,
				), self::HTTP_BAD_REQUEST
			);	
		} 
 
    }
   

	/**
     * @api {put} instituicoes-ensino-superior/:codIes Atualizar dados de uma Instituição de Ensino Superior.
     * @apiName update
     * @apiGroup Instituições de Ensino Superior
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam (Request Body/JSON) {String} nome   Nome da Instituição de Ensino Superior.
	 * @apiParam (Request Body/JSON) {String} abreviatura  Sigla da Instituição de Ensino Superior.
	 * 
	 * @apiSuccess {String} message  Instituição de Ensino Superior atualizada com sucesso.
	 *  
	 * @apiError {String[]} 404 O <code>codIes</code> não corresponde a uma Instituição de Ensino Superior cadastrada.
	 * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
	 */	
	public function update($codIes)
    {
		header("Access-Controll-Allow-Origin: *");

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
						'message' => array('Instituição de Ensino Superior atualizada com sucesso!')
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
                'error' => array('Instituição de Ensino Superior não encontrada!'),
				), self::HTTP_NOT_FOUND
			);
        }
	}
	

	/**
     * @api {delete} instituicoes-ensino-superior/:codIes Excluir uma Instituição de Ensino Superior.
     * @apiName delete
     * @apiGroup Instituições de Ensino Superior
	 * @apiPermission ADMINISTRATOR
	 * 
     * @apiParam {Number} codIes Identificador único da Instituição de Ensino Superior.
   	 * 
	 * @apiSuccess {String} message  Instituição de Ensino Superior deletada com sucesso.
	 *  
	 * @apiError {String[]} 404 O <code>codIes</code> não corresponde a uma Instituição de Ensino Superior cadastrada.
     */
	public function delete($codIes)
	{
		header("Access-Controll-Allow-Origin: *");

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
					'message' => array('Instituição de Ensino Superior removida com sucesso!')
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
                'error' => array('Instituição de Ensino Superior não encontrada!'),
				), self::HTTP_NOT_FOUND
			);
		}
	}
}