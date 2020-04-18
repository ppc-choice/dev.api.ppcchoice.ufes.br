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
			), 200);
		} else {
			$this->api_return(array(
				'status' => FALSE,
				'message' => 'Curso não encontrado!',
			), 404);
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
*    {
*      "codCurso": 2,
*      "nomeCurso": "Engenharia de Produção",
*      "anoCriacao": 2006,
*      "nomeUnidadeEnsino": "Campus São Mateus",
*      "nomeIes": "Universidade Federal do Espírito Santo"
*    },
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
		), 200);
    }
	
	/**
	 * @api {post} cursos/ Registrar um novo Curso.
	 * @apiName add
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
	
	 * @apiError CursoNotFound Não foi possível registrar um novo Curso.
	 * @apiSampleRequest cursos/
	 * @apiErrorExample {JSON} Error-Response:
	 * HTTP/1.1 404 OK
	 * {
	 *	"status": false,
	 *	"message": "Campo Obrigatorio Não Encontrado!"
	 * }
	 */
	public function add()
    {
        $this->_apiConfig(array(
            'methods' => array('POST'),
            )
        );
 
        $payload = json_decode(file_get_contents('php://input'),TRUE);
 
        if ( isset($payload['nome']) && isset($payload['unidadeEnsino']) && isset($payload['anoCriacao'])){
           
			$curso = new \Entities\Curso;
            $curso->setNome($payload['nome']);
			$curso->setAnoCriacao($payload['anoCriacao']);
			
			$ues = $this->entity_manager->find('Entities\UnidadeEnsino', $payload['unidadeEnsino']);
			
			if (!is_null($ues)){
				$curso->setUnidadeEnsino($ues);
				try {
					$this->entity_manager->persist($curso);
					$this->entity_manager->flush();
	 
					$this->api_return(array(
						'status' => TRUE,
						'message' => 'Curso criado com Sucesso!',
					), 200);
				} catch (\Exception $e) {
					$msg = $e->getMessage();
					$this->api_return(array(
						'status' => FALSE,
						'message' => $msg,
					), 400);
				}
				
			}else {
				$this->api_return(array(
					'status' => FALSE,
					'message' => 'Unidade de Ensino não identificado!',
				), 400);
			}
           
        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Campo Obrigatorio Não Encontrado!',
            ), 400);
        }
	}
	

	public function update($codCurso)
    {
        $curso = $this->entity_manager->find('Entities\Curso',$codCurso);
        $payload = json_decode(file_get_contents('php://input'),TRUE);
		$msg = '';
		
        if(!is_null($curso) && !empty($payload))
        {            

			if(isset($payload['unidadeEnsino']))
            {
                $ues = $this->entity_manager->find('Entities\UnidadeEnsino',$payload['unidadeEnsino']);
				if(is_null($ues))
				{
					 $msg = $msg . 'Unidade de Ensino Superior não encontrada. ';
				}
			}
			
            if(empty($msg))
            {
				$curso->setUnidadeEnsino($ues);
                if(isset($payload['nome']))
                {
                    $curso->setNome($payload['nome']);
                }
                if(isset($payload['anoCriacao']))
                {
                    $curso->setAnoCriacao($payload['anoCriacao']);
				}

                try {
                    $this->entity_manager->merge($curso);
                    $this->entity_manager->flush();
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => 'Curso atualizado com sucesso!'
                    ), 200);
                } catch (\Exception $e) {
                    $e_msg = $e->getMessage();
                    $this->api_return(array(
                        'status' => FALSE,
                        'message' => $e_msg
                    ), 400);
                }
            }else{
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $msg
                ), 404);
            } 
        }elseif(empty($payload))
        {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Corpo da Requisição vazio',
            ), 400);
        }else{
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Curso não encontrado!',
            ), 404);
        }
    }
}