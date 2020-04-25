
<?php defined('BASEPATH') OR exit('No direct script access allowed');



require_once APPPATH . 'libraries/API_Controller.php';


class DependenciaController extends API_Controller
{
    
    public function __construct() {
        parent::__construct();
    }

    /**
    * @api {get} dependencias Requisitar todas depêndencias existentes entre componentes curriculares.
    *
    * @apiName findAll
    * @apiGroup Dependência
    *
    * @apiSuccess {String} Curso Nome do curso que a componente curricular pertence.
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {String} nomeCompCurric Nome da uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    * @apiSuccess {String} nomePreReq Nome do pré-requisito da componente curricular.
    * 
    */

    public function findAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
           
            'methods' => array('GET'), 

        ));
        
        $dependencia = $this->entity_manager->getRepository('Entities\Dependencia')->findAll();
        $result = $this->doctrine_to_array($dependencia);
        
        if(!empty($result)){
            
            $this->api_return(
                array(
                    'status' => true,
                    "result" => $result,
                ),
            200);
        
        }else
        {
            $this->api_return(
                array(
                    'status' => false,
                    "message" => 'Depêndencia não encontrada!',
                ),
            404);
        }   
    }

    /**
    * @api {get} dependencias/:codCompCurric/:codPreReq Requisitar depêndencias entre componentes curriculares.
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
    * @apiExample {curl} Exemplo:
    *      curl -i http://dev.api.ppcchoice.ufes.br/dependencias/6/1
    * @apiSuccessExample {JSON} Success-Response:
    *   HTTP/1.1 200 OK
    *   {
    *     "Curso": "Ciência da Computação",
    *     "codCompCurric": 6,
    *     "nomeCompCurric": "Cálculo II",
    *     "codPreRequisito": 1
    *     "nomePreReq": "Cálculo II",
    *   }
    *
    * @apiErrorExample {JSON} Error-Response:
    *    HTTP/1.1 404 Not Found
    *    {
    *      "status": false,
    *      "message": "Dependência não encontrada!"
    *    }
    */

    public function findById($codCompCurric, $codPreReq)
    {
        
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
           
            'methods' => array('GET'), 

        ));
        
        $result = $this->entity_manager->getRepository('Entities\Dependencia')->findById($codCompCurric, $codPreReq);
    

        if(!empty($result)){
            
            $this->api_return(
                array(
                    'status' => true,
                    "result" => $result[0],
                ),
            200); 

        }else{
            
            $this->api_return(
                array(
                    'status' => false,
                    "message" => 'Dependencia não encontrada!',
                ),
            404);
        }
    }  


    /**
    * @api {get} projetos-pedagogicos-curso/:codPpc/dependencias Requisitar todas depêndencias entre componentes as curriculares de um Projeto Pedagógico de Curso.
    * @apiParam {Number} codPpc Código identificador de um projeto pedagógico de curso.
    *
    * @apiName findByIdPpc
    * @apiGroup Dependência
    *
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    *
    * @apiErrorExample {JSON} Error-Response:
    *     HTTP/1.1 404 Not Found
    *     {
    *       "status": false,
    *       "message": "Não foram encontradas dependências para este projeto pedagógico de curso!"
    *     }
    */
    
    public function findByIdPpc($codPpc)
    {
        
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
           
            'methods' => array('GET'), 

        ));
    
        $dependencia = $this->entity_manager->getRepository('Entities\Dependencia')->findByIdPpc($codPpc);
        $result = $this->doctrine_to_array($dependencia);

        if(!empty($result)){
            
            $this->api_return(
                array(
                    'status' => true,
                    "result" => $result,
                ),
            200); 

        }else{
            
            $this->api_return(
                array(
                    'status' => false,
                    "message" => 'Não foram encontradas dependências para este projeto pedagógico de curso!',
                ),
            404);
        }
    } 

    /**
    * @api {post} dependencias Criar nova depêndencia entre componentes curriculares.
    *
    * @apiName add
    * @apiGroup Dependência
    *
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    * 
    * @apiExample {curl} Exemplo:
	*     curl -i http://dev.api.ppcchoice.ufes.br/dependencias
	* @apiParamExample {json} Request-Example:
    * {
    *     "codCompCurric": 6,
    *     "codPreRequisito": 1
    * }
    *
    * @apiSuccessExample {JSON} Success-Response:
    * HTTP/1.1 200 OK
	* {
	* 	"status": true,
	* 	"result": "Dependencia criada com sucesso!"
	* {
    *
    * @apiError CursoNotFound Não foi possível registrar um novo Curso.
	* @apiSampleRequest dependencias
	* @apiErrorExample {JSON} Error-Response:
	*/
    

    public function create()
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('POST'),
			)
		);

		$payload = json_decode(file_get_contents('php://input'),TRUE);
        $dependencia = new Entities\Dependencia;
        
        if ( isset($payload['codCompCurric']))
        {
            $componenteCurricular = $this->entity_manager->find('Entities\ComponenteCurricular', $payload['codCompCurric']);
            $dependencia->setComponenteCurricular($componenteCurricular);
        }
        if( isset($payload['codPreRequisito'])) 
        {
            $preRequisito = $this->entity_manager->find('Entities\ComponenteCurricular', $payload['codPreRequisito']);
            $dependencia->setPreRequisito($preRequisito);
        }
        
        $validador = $this->validator->validate($dependencia);

        if ( $validador->count() ){
    
            $msg = $validador->messageArray();

            $this->api_return(array(
                'status' => FALSE,
                'message' => $msg,
            ), 400);
        }else{
            try {
                $this->entity_manager->persist($dependencia);
                $this->entity_manager->flush();
                $this->api_return(array(
                    'status' => TRUE,
                    'message' => 'Dependencia criada com sucesso'
                ), 200);

            } catch ( \Exception $e ){
                $e_msg = $e->getMessage();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $e_msg
                ), 400);
            }
        }
    }   		
    /**
    * @api {PUT} dependencias Criar nova depêndencia entre componentes curriculares.
    *
    * @apiName update
    * @apiGroup Dependência
    *
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    * 
    * @apiExample {curl} Exemplo:
	*     curl -i http://dev.api.ppcchoice.ufes.br/dependencias/6/1
	* @apiParamExample {json} Request-Example:
    * {
    *     "codCompCurric": 8,
    *     "codPreRequisito": 1
    * }
    *
    * @apiSuccessExample {JSON} Success-Response:
    * HTTP/1.1 200 OK
	* {
	* 	"status": true,
	* 	"result": "Dependencia atualizada com sucesso!"
	* {
    *
    * @apiError CursoNotFound Não foi possível atualizar Dependeência.
	* @apiSampleRequest dependencias
	* @apiErrorExample {JSON} Error-Response:
	*/
    
    public function update($codCompCurric, $codPreRequisito)
	{
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('PUT'),
            )
        );

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $dependencia = $this->entity_manager->find('Entities\Dependencia',
        	array('componenteCurricular' => $codCompCurric, 'preRequisito' => $codPreRequisito));
        
        //Verifica se  existe dependencia entre as componentes curriculares 
        if(!is_null($dependencia))
        {

            if(isset($payload['codCompCurric']))
            {
                $cc = $this->entity_manager->find('Entities\ComponenteCurricular',
                	array('codCompCurric' => $payload['codCompCurric']));
                $dependencia->setComponenteCurricular($cc);
            }

            if(isset($payload['codPreRequisito']))
            {       
                $pr = $this->entity_manager->find('Entities\ComponenteCurricular',
                	array('codCompCurric' => $payload['codPreRequisito']));
                $dependencia->setPreRequisito($pr);
            }
            
            $validador = $this->validator->validate($dependencia);
            if ($validador->count())
            {
                $message = $validador->messageArray();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $message
                ), 400);

            } else
            {
                try
                {
                    $this->entity_manager->merge($dependencia);
                    $this->entity_manager->flush();
                                
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => 'Dependencia atualizada com sucesso',
                    ), 200);
                } catch (\Exception $e) {
                    $this->api_return(array(
                        'status' => false,
                        'message' => $e->getMessage(),
                    ), 400);
                }
            }
        
        } elseif(empty($payload))
        {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Não há requisição',
            ), 400);
    
        }else
        {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Campo obrigatorio não encontrado',
            ), 400);
        }
    }

    /**
    * @api {DELETE} dependencias Deletar depêndencia entre componentes curriculares.
    *
    * @apiName update
    * @apiGroup Dependência
    *
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    * 
    * @apiExample {curl} Exemplo:
	*     curl -i http://dev.api.ppcchoice.ufes.br/dependencias/6/1
    *
    * @apiSuccessExample {JSON} Success-Response:
    * HTTP/1.1 200 OK
	* {
	* 	"status": true,
	* 	"result": "Dependencia deletada com sucesso!"
	* {
    *
    * @apiError CursoNotFound Não foi possível deletar Dependeência.
	* @apiSampleRequest dependencias
	* @apiErrorExample {JSON} Error-Response:
    */
    public function delete($codCompCurric, $codPreRequisito)
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('DELETE'),
			)
		);

	
        $dependencia = $this->entity_manager->find('Entities\Dependencia',array('componenteCurricular' => $codCompCurric, 'preRequisito' => $codPreRequisito));
            
        if(!is_null($dependencia))
        {
            try
            {
                $this->entity_manager->remove($dependencia);
                $this->entity_manager->flush();
                
                $this->api_return(array(
                    'status' => TRUE,
                    'message' => 'Dependencia deletada com sucesso',
                ), 200);
            } catch (\Exception $e) {
                $this->api_return(array(
                    'status' => false,
                    'message' => $e->getMessage(),
                ), 400);
            }
        }
        else
        {   
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Dependência não encontrada',
            ), 400);

        }
        	
			
    }
} 