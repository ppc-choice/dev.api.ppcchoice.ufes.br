<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class CursoController extends API_Controller {

	/**
	 * @api {get} cursos/:codCurso Solicitar dados de um Curso.
	 * @apiName findById
	 * @apiGroup Cursos
	 *
	 * @apiParam {Number} codCurso Identificador único do Curso requerido.
	 *
	 * @apiSuccess {String} nome   Nome do Curso.
	 * @apiSuccess {Number} anoCriacao  Ano em que o curso foi criado.
	 * @apiSuccess {Number} codUnidadeEnsino   Identificador único da Unidade de Ensino na qual o Curso está registrado.
	 * 
	 * @apiError {String[]} 404 O <code>codCurso</code> não corresponde a um Curso cadastrado.
	 * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
	 */
    public function findById($codCurso)
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
			), self::HTTP_OK);
		} else {
			$this->api_return(array(
				'status' => FALSE,
				'message' => array('Curso não encontrado!'),
			), self::HTTP_NOT_FOUND);
		}
    }
    
	/**
	 * @api {get} cursos/ Requisitar todos Cursos registrados.
	 * @apiName findAll
	 * @apiGroup Cursos
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiSuccess {cursos[]} Curso Array de objetos do tipo Cursos.
	 */
    public function findAll()
	{   
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);

        $curso = $this->entity_manager->getRepository('Entities\Curso')->findAll();
        $result = $this->doctrine_to_array($curso,TRUE);

		$this->api_return(array(
			'status' => TRUE,
			'result' => $result,
		), self::HTTP_OK);
    }
	
	/**
	 * @api {post} cursos/ Criar um Curso.
	 * @apiName create
	 * @apiGroup Cursos
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam (Request Body/JSON) {String} nome   Nome do Curso.
	 * @apiParam (Request Body/JSON) {Number} anoCriacao  Ano em que o curso foi criado.
	 * @apiParam (Request Body/JSON) {Number} codUnidadeEnsino   Identificador único da Unidade de Ensino na qual o Curso está registrado.
	 * 
	 * @apiError {String[]} 404 O <code>codCurso</code> não corresponde a um Curso cadastrado.
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
		
		$curso = new \Entities\Curso;

		if ( array_key_exists('nome', $payload) ) $curso->setNome($payload['nome']);
		if ( array_key_exists('anoCriacao', $payload) ) $curso->setAnoCriacao($payload['anoCriacao']);
 
        if (isset($payload['codUnidadeEnsino'])){
			$ues = $this->entity_manager->find('Entities\UnidadeEnsino', $payload['codUnidadeEnsino']);
			$curso->setUnidadeEnsino($ues);
		}

			$validacao = $this->validator->validate($curso);

			if ( $validacao->count() ){
				$msg = $validacao->messageArray();
	
				$this->api_return(array(
					'status' => FALSE,
					'message' => $msg,
				), self::HTTP_BAD_REQUEST);	
			} else {
				try {
					$this->entity_manager->persist($curso);
					$this->entity_manager->flush();
		
					$this->api_return(array(
						'status' => TRUE,
						'message' => array('Curso criado com Sucesso!'),
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
     * @api {put} cursos/:codCurso Atualizar dados de um Curso.
     * @apiName update
     * @apiGroup Cursos
	 * @apiPermission ADMINISTRATOR
	 * 
     * @apiParam (Request Body/JSON) {String} nome   Nome do Curso.
	 * @apiParam (Request Body/JSON) {Number} anoCriacao  Ano em que o curso foi criado.
	 * @apiParam (Request Body/JSON) {Number} codUnidadeEnsino   Identificador único da Unidade de Ensino na qual o Curso está registrado.
	 * 
	 * @apiSuccess {String} message Curso atualizado com sucesso.
	 * 
	 * @apiError {String[]} 404 O <code>codCurso</code> não corresponde a um Curso cadastrado.
	 * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
	public function update($codCurso)
    {
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('PUT'),
			)
		);

        $curso = $this->entity_manager->find('Entities\Curso',$codCurso);
        $payload = json_decode(file_get_contents('php://input'),TRUE);
		
        if(!is_null($curso))
        {            
			if(isset($payload['codUnidadeEnsino']))
            {
                $ues = $this->entity_manager->find('Entities\UnidadeEnsino',$payload['codUnidadeEnsino']);
				$curso->setUnidadeEnsino($ues);
			}
				if ( array_key_exists('nome', $payload) ) $curso->setNome($payload['nome']);
                if ( array_key_exists('anoCriacao', $payload) ) $curso->setAnoCriacao($payload['anoCriacao']);

				$validacao = $this->validator->validate($curso);

				if ( $validacao->count() ){
					$msg = $validacao->messageArray();
		
					$this->api_return(array(
						'status' => FALSE,
						'message' => $msg,
					), self::HTTP_BAD_REQUEST);	
				} else {
					try {
						$this->entity_manager->merge($curso);
						$this->entity_manager->flush();
						$this->api_return(array(
							'status' => TRUE,
							'message' => array('Curso atualizado com sucesso!')
						), self::HTTP_OK);
					} catch (\Exception $e) {
						$e_msg = array($e->getMessage());
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
                'message' => array('Corpo da Requisição vazio'),
            ), self::HTTP_BAD_REQUEST);
        }else{
            $this->api_return(array(
                'status' => FALSE,
                'message' => array('Curso não encontrado!'),
            ), self::HTTP_NOT_FOUND);
        }
	}

	/**
     * @api {delete} cursos/:codCurso Excluir um Curso.
     * @apiName delete
     * @apiGroup Cursos
	 * @apiPermission ADMINISTRATOR
	 * 
     * @apiParam {Number} codCurso Identificador único do Curso.
   	 * 
	 * @apiSuccess {String} message  Curso deletado com sucesso.
	 *  
	 * @apiError {String[]} 404 O <code>codCurso</code> não corresponde a uma Curso cadastrado.
     */
	public function delete($codCurso)
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('DELETE'),
			)
		);

		$curso = $this->entity_manager->find('Entities\Curso',$codCurso);
		
		if(!is_null($curso))
		{
			try {
				$this->entity_manager->remove($curso);
				$this->entity_manager->flush();
				$this->api_return(array(
					'status' => TRUE,
					'message' => array('Curso removida com sucesso!')
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
                'message' => array('Curso não encontrada!'),
            ), self::HTTP_NOT_FOUND);
		}
	}
}