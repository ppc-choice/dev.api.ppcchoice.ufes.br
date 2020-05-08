<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class DependenciaController extends APIController
{
    public function __construct() {
        parent::__construct();
    }

    /**
    * @api {get} dependencias Requisitar todas dependências existentes entre componentes curriculares.
    *
    * @apiName findAll
    * @apiGroup Dependência
    *
    * @apiSuccess {String[]} Dependência Array de objetos do tipo depenência.
    */
    public function findAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));
        
        $colecaoDependencia = $this->entityManager->getRepository('Entities\Dependencia')->findAll();        
        
        if(!empty($colecaoDependencia)){
            $this->apiReturn($colecaoDependencia,
                self::HTTP_OK
            );
        }else
        {
            $this->apiReturn(
                array(
                    'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
                ), self::HTTP_NOT_FOUND
            );
        }   
    }

    /**
    * @api {get} dependencias/:codCompCurric/:codPreReq Requisitar dependências entre componentes curriculares.
    * @apiParam {Number} codCompCurric Código de identificação de uma componente curricular.
    * @apiParam {Number} codPreReq Código de identificação de uma componente curricular que é pré-requisito.
    *
    * @apiName findById
    * @apiGroup Dependência
    *
    * @apiSuccess {String} Curso Nome do curso que a componente curricular pertence.
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {String} nomeCompCurric Nome da uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    * @apiSuccess {String} nomePreReq Nome do pré-requisito da componente curricular.
    *     
    * @apiError {String[]} 404 Os códigos <code>:codCompCurric</code> e <code>:codPreRequisito</code> não corresponde a uma dependência cadastrada.
    */
    public function findById($codCompCurric, $codPreRequisito)
    {
        
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));
        
        $dependencia = $this->entityManager->getRepository('Entities\Dependencia')->findById($codCompCurric, $codPreRequisito);

        if(!empty($dependencia)){
            $this->apiReturn($dependencia,
                self::HTTP_OK
            ); 
        }else{
            
            $this->apiReturn(
                array(
                    'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
                ), self::HTTP_NOT_FOUND
            );
        }
    }  


    /**
    * @api {get} projetos-pedagogicos-curso/:codPpc/dependencias Requisitar todas dependências entre componentes as curriculares de um Projeto Pedagógico de Curso.
    * @apiParam {Number} codPpc Código identificador de um projeto pedagógico de curso.
    *
    * @apiName findByIdPpc
    * @apiGroup Dependência
    *
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    *
    * @apiError {String[]} 404 O  <code>:codPpc</code> não corresponde a uma Projeto Peedagógico de Curso cadastrada.
    */
    public function findByIdPpc($codPpc)
    {
        
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));
    
        $colecaoDependencia = $this->entityManager->getRepository('Entities\Dependencia')->findByIdPpc($codPpc);
        
        if(!empty($colecaoDependencia)){
            $colecaoDependencia = $this->doctrineToArray($colecaoDependencia);
            
            $this->apiReturn($colecaoDependencia,
                self::HTTP_OK 
            ); 
        }else{    
            $this->apiReturn(
                array(
                    'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
                ), self::HTTP_NOT_FOUND 
            );
        }
    } 

    /**
    * @api {post} dependencias Criar uma nova dependência entre componentes curriculares.
    *
    * @apiName create
    * @apiGroup Dependência
    *
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    * 
    * @apiSuccess {String} message  Dependência criada com sucesso.
    *
    * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
    *
	*/
    public function create()
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('POST'),
			)
		);

		$payload = json_decode(file_get_contents('php://input'),TRUE);
        $dependencia = new Entities\Dependencia();
        
        if ( isset($payload['codCompCurric'])){

            $componenteCurricular = $this->entityManager->find('Entities\ComponenteCurricular', $payload['codCompCurric']);
            $dependencia->setComponenteCurricular($componenteCurricular);
        }

        if( isset($payload['codPreRequisito'])){

            $preRequisito = $this->entityManager->find('Entities\ComponenteCurricular', $payload['codPreRequisito']);
            $dependencia->setPreRequisito($preRequisito);
        }

        $constraints = $this->validator->validate($dependencia);

        if ( $constraints->success() ){
            try{
                $this->entityManager->persist($dependencia);
                $this->entityManager->flush();

                $this->apiReturn(array(
                    'message' => $this->stdMessage(STD_MSG_CREATED),
                    ), self::HTTP_OK 
                );

            }catch ( \Exception $e ){
                $this->apiReturn(array(
                    'error' => $this->stdMessage(STD_MSG_EXCEPTION),
                    ), self::HTTP_BAD_REQUEST 
                );
            }
        }else{
            $this->apiReturn(array(
                'error' => $constraints->messageArray(),
                ), self::HTTP_BAD_REQUEST 
            );
        }
    }

    /**
    * @api {PUT} dependencias Criar nova depêndencia entre componentes curriculares.
    *
    * @apiName update
    * @apiGroup Dependência
    *
    * @apiParam (Request Body/JSON ) {Number} [codCompCurric] Código identificador de uma componente curricular.
    * @apiParam (Request Body/JSON ) {Number} [codPreRequisito] Código identificador de uma componente curricular que é pré-requisito.
    *
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    * 
    * @apiSuccess {String} message  Dependência atualizada com sucesso.
    *
    * @apiError {String[]} 404 Os códigos <code>:codCompCurric</code> e <code>:codpreRequisito</code> não correspondem a uma dependência cadastrada.
    * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
    */
    public function update($codCompCurric, $codPreRequisito)
	{
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('PUT'),
            )
        );

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $dependencia = $this->entityManager->find('Entities\Dependencia',
        	array('componenteCurricular' => $codCompCurric, 'preRequisito' => $codPreRequisito));
        
        //Verifica se  existe dependencia entre as componentes curriculares 
        if(!is_null($dependencia)){

            if(array_key_exists('codCompCurric', $payload)){
                if(isset($payload['codCompCurric'])){
                    $componenteCurricular = $this->entityManager->find('Entities\ComponenteCurricular', $payload['codCompCurric']);
                }else{
                    $componenteCurricular = null;    
                }
                $dependencia->setComponenteCurricular($componenteCurricular);
            }
            
            if(array_key_exists('codPreRequisito', $payload)){       
                if(isset($payload['codPreRequisito'])){
                    $preRequisito = $this->entityManager->find('Entities\ComponenteCurricular', $payload['codPreRequisito']);
                }else{
                    $preRequisito = null;    
                }
                $dependencia->setPreRequisito($preRequisito);
            }
            
            $constraints = $this->validator->validate($dependencia);
            
            if ($constraints->success()){

                try{
                    $this->entityManager->merge($dependencia);
                    $this->entityManager->flush();
                                
                    $this->apiReturn(array(
                        'message' => $this->stdMessage(STD_MSG_UPDATED),
                        ), self::HTTP_OK 
                    );

                } catch (\Exception $e){
                    $this->apiReturn(array(
                        'error' => $this->stdMessage(STD_MSG_EXCEPTION),
                        ), self::HTTP_BAD_REQUEST 
                    );
                }
                
            }else{
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
    * @api {DELETE} dependencias Deletar dependência entre componentes curriculares.
    *
    * @apiName delete
    * @apiGroup Dependência
    *
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    *
    * @apiSuccess {String} message  Dependência deletada com sucesso.
    *
    * @apiError {String[]} 404 Os códigos <code>:codCompCurric</code> e <code>:codPreRequisito</code> não correspondem a uma dependência cadastrada.
    */
    public function delete($codCompCurric, $codPreRequisito)
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('DELETE'),
			)
		);
	
        $dependencia = $this->entityManager->find('Entities\Dependencia',array('componenteCurricular' => $codCompCurric, 'preRequisito' => $codPreRequisito));
            
        if(!is_null($dependencia)){
            try{
                $this->entityManager->remove($dependencia);
                $this->entityManager->flush();
                
                $this->apiReturn(array(
                    'message' => $this->stdMessage(STD_MSG_DELETED),
                    ), self::HTTP_OK 
                );

            }catch (\Exception $e){
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