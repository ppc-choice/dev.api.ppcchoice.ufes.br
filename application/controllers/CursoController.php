<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class CursoController extends API_Controller {

	/**
	 * @api {get} cursos/:codCurso Requisitar dados de um Curso específico.
	 * @apiName findById
	 * @apiGroup Cursos
	 *
	 * @apiParam {Number} codCurso Identificador único do Curso requerido.
	 *
	 * @apiSuccess {String} nome   Nome do Curso.
	 * @apiSuccess {Number} anoCriacao  Ano em que o curso foi criado.
	 * @apiSuccess {Number} unidadeEnsino   Identificador único da Unidade de Ensino na qual o Curso está registrado.
	 * @apiExample {curl} Exemplo:
	 *     curl -i http://dev.api.ppcchoice.ufes.br/cursos/1
	 * @apiSuccessExample {JSON} Success-Response:
	 * HTTP/1.1 200 OK
	 * {
	 *	"status": true,
	 *	"result": {
	 *	"codCurso": 1,
     *	"nome": "Ciência da Computação",
     *	"anoCriacao": 2011,
     *	"codUnEnsino": 1
	 * }
	 * @apiError UserNotFound O <code>codCurso</code> não corresponde a nenhum Curso cadastrado.
	 * @apiSampleRequest cursos/:codCurso
	 * @apiErrorExample {JSON} Error-Response:
	 * HTTP/1.1 404 OK
	 * {
	 *	"status": false,
	 *	"message": "Curso não encontrado!"
	 * }
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
	 * @apiSuccess {Number} codCurso   Identificador único do curso.
	 * @apiSuccess {String} nome   Nome do curso.
	 * @apiSuccess {Number} anoCriacao  Ano em que o curso foi criado.
	 * @apiSuccess {Number} unidadeEnsino   Identificador único da Unidade de Ensino na qual o Curso está registrado.
	 * @apiExample {curl} Exemplo:
	 *     curl -i http://dev.api.ppcchoice.ufes.br/cursos/
	 * @apiSuccessExample {JSON} Success-Response:
	 * HTTP/1.1 200 OK
	* 
*  "status": true,
*  "result": [
*    {
*      "codCurso": 1,
*      "nomeCurso": "Ciência da Computação",
*      "anoCriacao": 2011,
*      "nomeUnidadeEnsino": "Campus São Mateus",
*      "nomeIes": "Universidade Federal do Espírito Santo"
*    },
*   ...,
*    {
*      "codCurso": 3,
*      "nomeCurso": "Matemática Industrial",
*      "anoCriacao": 2013,
*      "nomeUnidadeEnsino": "Campus São Mateus",
*      "nomeIes": "Universidade Federal do Espírito Santo"
*    }
*  ]
*}

	 * @apiError UserNotFound Nenhum Curso cadastrado.
	 * @apiSampleRequest cursos/
	 * @apiErrorExample {JSON} Error-Response:
	 * HTTP/1.1 404 OK
	 * {
	 *	"status": false,
	 *	"message": "Nenhum Curso cadastrado!"
	 * }
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
	 * @apiSuccess {String} nome   Nome do Curso.
	 * @apiSuccess {Number} anoCriacao  Ano em que o curso foi criado.
	 * @apiSuccess {Number} unidadeEnsino   Identificador único da Unidade de Ensino na qual o Curso está registrado.
	 * @apiExample {curl} Exemplo:
	 *     curl -i http://dev.api.ppcchoice.ufes.br/cursos/
	 * @apiParamExample {json} Request-Example:
     * {
     *   "nome": "Novo Curso",
     *	 "anoCriacao": 2020,
     *	 "unidadeEnsino": 1
     * }
	 * @apiSuccessExample {JSON} Success-Response:
	 * HTTP/1.1 200 OK
	* {
	* 	"status": true,
	* 	"result": "Curso criado com Sucesso!"
	* {
	
	 * @apiError CursoNotFound Não foi possível criar um novo Curso.
	 * @apiSampleRequest cursos/
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
		
		$curso = new \Entities\Curso;

		if ( isset($payload['nome']) ) $curso->setNome($payload['nome']);
		if ( isset($payload['anoCriacao']) ) $curso->setAnoCriacao($payload['anoCriacao']);
 
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
     * @api {put} cursos/:codCurso Atualizar Curso
     * @apiName update
     * @apiGroup Cursos
     * @apiParam {Number} codCurso Código do Curso.
     * @apiError  (Campo obrigatorio não encontrado 400) BadRequest Algum campo obrigatório não foi inserido.
     * @apiError  (Curso não encontrado 404) Curso não encontrada
     * @apiParamExample {json} Request-Example:
     *     {
     *         "nome" : "Ciência dos Dados",
	 *         "anoCriacao" : 2020 ,
	 *         "unidadeEnsino" : 1
     *     }
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Curso atualizado com sucesso"
     *     }
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
			
                if(isset($payload['nome'])) $curso->setNome($payload['nome']);
                if(isset($payload['anoCriacao'])) $curso->setAnoCriacao($payload['anoCriacao']);

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
     * @api {delete} cursos/:codCurso Deletar Curso.
     * @apiName delete
     * @apiGroup Cursos
     * @apiParam {Number} codCurso Código do Curso.
     * @apiError  (Campo não encontrado 400) NotFound Curso não encontrado.
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Curso removido com sucesso"
     *     }
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