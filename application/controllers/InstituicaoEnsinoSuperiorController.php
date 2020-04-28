<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';


class InstituicaoEnsinoSuperiorController extends API_Controller
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
		
        $ies = $this->entity_manager->getRepository('Entities\InstituicaoEnsinoSuperior')->findAll();
        
        $result = $this->doctrine_to_array($ies,TRUE);

		$this->api_return(array(
			'status' => TRUE,
			'result' => $result,
		), self::HTTP_OK);
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
		
		$ies = $this->entity_manager->find('Entities\InstituicaoEnsinoSuperior',$codIes);
		
		if ( !is_null($ies) ) {
			$result = $this->doctrine_to_array($ies,TRUE);	
			$this->api_return(array(
				'status' => TRUE,
				'result' => $result,
			), self::HTTP_OK);
		} else {
			$this->api_return(array(
				'status' => FALSE,
				'message' => array('Instituicao de Ensino Superior não encontrada!'),
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

		$ies = new \Entities\InstituicaoEnsinoSuperior;

		if ( array_key_exists('codIes', $payload) ) $ies->setCodIes($payload['codIes']);
		if ( array_key_exists('nome', $payload) ) $ies->setNome($payload['nome']);
		if ( array_key_exists('abreviatura', $payload) ) $ies->setAbreviatura($payload['abreviatura']);

		$validacao = $this->validator->validate($ies);

		if ( $validacao->count() ){		
			$msg = $validacao->messageArray();

			$this->api_return(array(
				'status' => FALSE,
				'message' => $msg,
			), self::HTTP_BAD_REQUEST);	
		}else {
			try {
				$this->entity_manager->persist($ies);
				$this->entity_manager->flush();
	
				$this->api_return(array(
					'status' => TRUE,
					'result' => array('Instituicao de Ensino Superior Criada com Sucesso!'),
				), self::HTTP_OK);
			} catch (\Exception $e) {
				$msg = array($e->getMessage());
				$this->api_return(array(
					'status' => FALSE,
					'message' => $msg,
				), self::HTTP_BAD_REQUEST);
			}	
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
		
        $ies = $this->entity_manager->find('Entities\InstituicaoEnsinoSuperior',$codIes);
        $payload = json_decode(file_get_contents('php://input'),TRUE);
		
        if(!is_null($ies))
        {            
			if ( array_key_exists('nome', $payload) ) $ies->setNome($payload['nome']);
			if ( array_key_exists('abreviatura', $payload) ) $ies->setAbreviatura($payload['abreviatura']);
			
			$validacao = $this->validator->validate($ies);

			if ( $validacao->count()){
				$msg = $validacao->messageArray();
	
				$this->api_return(array(
					'status' => FALSE,
					'message' => $msg,
				), self::HTTP_BAD_REQUEST);	
			} else {
				try {
					$this->entity_manager->merge($ies);
					$this->entity_manager->flush();
					$this->api_return(array(
						'status' => TRUE,
						'message' => array('Instituição de Ensino Superior atualizada com sucesso!')
					), self::HTTP_OK);
					
				} catch (\Exception $e) {
					$msg = array($e->getMessage());
					$this->api_return(array(
						'status' => FALSE,
						'message' => $msg
					), self::HTTP_BAD_REQUEST);
				}	
			}

        }elseif(empty($payload))
        {
            $this->api_return(array(
                'status' => FALSE,
                'message' => array('Corpo da Requisição vazio'),
            ), self::HTTP_BAD_REQUEST);
        }else{
            $this->api_return(array(
                'status' => FALSE,
                'message' => array('Instituição de Ensino Superior não encontrada!'),
            ), self::HTTP_NOT_FOUND);
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

		$ies = $this->entity_manager->find('Entities\InstituicaoEnsinoSuperior',$codIes);
		
		if(!is_null($ies))
		{
			try {
				$this->entity_manager->remove($ies);
				$this->entity_manager->flush();
				$this->api_return(array(
					'status' => TRUE,
					'message' => array('Instituição de Ensino Superior removida com sucesso!')
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
                'message' => array('Instituição de Ensino Superior não encontrada!'),
            ), self::HTTP_NOT_FOUND);
		}
	}
}