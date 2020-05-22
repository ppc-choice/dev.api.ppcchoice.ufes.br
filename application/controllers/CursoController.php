<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class CursoController extends APIController 
{
	public function __construct() {
        parent::__construct();
	}
	
	/**
	 * @api {get} cursos Solicitar todos Cursos registrados.
	 * @apiName findAll
	 * @apiGroup Curso
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiSuccess {Curso[]} curso Array de objetos do tipo Curso.
	 * 
	 * @apiError {String[]} error Entities\\Curso: Instância não encontrada.
	 */
	public function findAll()
	{   
		header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);

		$colecaoCurso = $this->entityManager->getRepository('Entities\Curso')->findAll();
		$colecaoCurso = $this->doctrineToArray($colecaoCurso,TRUE);

		if (!empty($colecaoCurso)){
			$this->apiReturn($colecaoCurso,
				self::HTTP_OK
			);

		} else {
            $this->apiReturn(
                array(
                    'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
                ),self::HTTP_NOT_FOUND
            );
        }
	}
	
	/**
	 * @api {get} cursos/:codCurso Solicitar dados de um Curso.
	 * @apiName findById
	 * @apiGroup Curso
	 *
	 * @apiParam {Number} codCurso Identificador único do Curso requerido.
	 *
	 * @apiSuccess {String} nome   Nome do Curso.
	 * @apiSuccess {Number} anoCriacao  Ano em que o curso foi criado.
	 * @apiSuccess {Number} codUnidadeEnsino   Identificador único da Unidade de Ensino na qual o Curso está registrado.
	 * 
	 * @apiError {String[]} error Entities\\Curso: Instância não encontrada.
	 */
    public function findById($codCurso)
	{   
		header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
		$curso = $this->entityManager->find('Entities\Curso',$codCurso);
        
		if ( !is_null($curso) ) {
			$curso = $this->doctrineToArray($curso,TRUE);	
			
			$this->apiReturn($curso,
				self::HTTP_OK
			);
		} else {
			$this->apiReturn(array(
				'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
				), self::HTTP_NOT_FOUND
			);
		}
    }
    
	/**
	 * @api {post} cursos Criar um Curso.
	 * @apiName create
	 * @apiGroup Curso
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam (Request Body/JSON) {String} nome   Nome do Curso.
	 * @apiParam (Request Body/JSON) {Number{1950-2020}} anoCriacao  Ano em que o curso foi criado.
	 * @apiParam (Request Body/JSON) {Number} codUnidadeEnsino   Identificador único da Unidade de Ensino na qual o Curso está registrado.
	 * 
	 * @apiSuccess {String[]} message  Entities\\Curso: Instância criada com sucesso.
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
		$curso = new Entities\Curso();

		if ( array_key_exists('nome', $payload) ) $curso->setNome($payload['nome']);

		if ( array_key_exists('anoCriacao', $payload) ) $curso->setAnoCriacao($payload['anoCriacao']);
 
        if (isset($payload['codUnidadeEnsino'])){
			$ues = $this->entityManager->find('Entities\UnidadeEnsino', $payload['codUnidadeEnsino']);
			$curso->setUnidadeEnsino($ues);
		}

			$constraints = $this->validator->validate($curso);

			if ( $constraints->success() ){
				try {
					$this->entityManager->persist($curso);
					$this->entityManager->flush();
		
					$this->apiReturn(array(
						'message' => $this->stdMessage(STD_MSG_CREATED),
						), self::HTTP_OK
					);
				} catch (\Exception $e) {
					$this->apiReturn(array(
						'error' => $this->stdMessage(STD_MSG_EXCEPTION),
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
     * @api {put} cursos/:codCurso Atualizar dados de um Curso.
     * @apiName update
     * @apiGroup Curso
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam {Number} codCurso Identificador único do Curso requerido.
	 * 
     * @apiParam (Request Body/JSON) {String} [nome]   Nome do Curso.
	 * @apiParam (Request Body/JSON) {Number{1950-2020}} [anoCriacao]  Ano em que o curso foi criado.
	 * @apiParam (Request Body/JSON) {Number} [codUnidadeEnsino]   Identificador único da Unidade de Ensino na qual o Curso está registrado.
	 * 
	 * @apiSuccess {String[]} message Entities\\Curso: Instância atualizada com sucesso.
	 * 
	 * @apiError {String[]} error Entities\\Curso: Instância não encontrada.
	 * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
     */
	public function update($codCurso)
    {
		header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('PUT'),
			)
		);

        $curso = $this->entityManager->find('Entities\Curso',$codCurso);
        $payload = json_decode(file_get_contents('php://input'),TRUE);
		
        if(!is_null($curso))
        {            
			if(array_key_exists('codUnidadeEnsino', $payload))
            {
				if (is_numeric($payload['codUnidadeEnsino'])){
					$ues = $this->entityManager->find('Entities\UnidadeEnsino',$payload['codUnidadeEnsino']);
					$curso->setUnidadeEnsino($ues);
				}else{
					$curso->setUnidadeEnsino(null);
				}
			}
			
			if ( array_key_exists('nome', $payload) ) $curso->setNome($payload['nome']);
			
			if ( array_key_exists('anoCriacao', $payload) ) $curso->setAnoCriacao($payload['anoCriacao']);

			$constraints = $this->validator->validate($curso);

			if ( $constraints->success() ){
				try {
					$this->entityManager->merge($curso);
					$this->entityManager->flush();

					$this->apiReturn(array(
						'message' => $this->stdMessage(STD_MSG_UPDATED),
						), self::HTTP_OK
					);
				} catch (\Exception $e) {
					$this->apiReturn(array(
						'error' => $this->stdMessage(STD_MSG_EXCEPTION),
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
                'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
				), self::HTTP_NOT_FOUND
			);
        }
	}

	/**
     * @api {delete} cursos/:codCurso Excluir um Curso.
     * @apiName delete
     * @apiGroup Curso
	 * @apiPermission ADMINISTRATOR
	 * 
     * @apiParam {Number} codCurso Identificador único do Curso.
   	 * 
	 * @apiSuccess {String[]} message  Entities\\Curso: Instância removida com sucesso.
	 *  
	 * @apiError {String[]} error Entities\\Curso: Instância não encontrada.
     */
	public function delete($codCurso)
	{
		header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('DELETE'),
			)
		);

		$curso = $this->entityManager->find('Entities\Curso',$codCurso);
		
		if(!is_null($curso))
		{
			try {
				$this->entityManager->remove($curso);
				$this->entityManager->flush();

				$this->apiReturn(array(
					'message' => $this->stdMessage(STD_MSG_DELETED),
				), self::HTTP_OK);
				
			} catch (\Exception $e) {
				$this->apiReturn(array(
					'error' => $this->stdMessage(STD_MSG_EXCEPTION),
					), self::HTTP_BAD_REQUEST
				);
			}
		}else{
			$this->apiReturn(array(
                'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
				), self::HTTP_NOT_FOUND
			);
		}
	}
}