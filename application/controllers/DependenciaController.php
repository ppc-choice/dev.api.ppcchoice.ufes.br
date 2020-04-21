
<?php defined('BASEPATH') OR exit('No direct script access allowed');



require_once APPPATH . 'libraries/API_Controller.php';


class DependenciaController extends API_Controller
{
    
    public function __construct() {
        parent::__construct();
    }

    /**
    * @api {get} dependencias Solicitar todas depêndencias existentes entre componentes curriculares.
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
    * @api {get} dependencias/:codCompCurric/:codPreReq Solicitar depêndencias entre componentes curriculares.
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
    * @api {get} projetos-pedagogicos-curso/:codPpc/dependencias Solicitar todas depêndencias entre componentes as curriculares de um Projeto Pedagógico de Curso.
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
    * @api {post} dependencias Adicionar nova depêndencia entre componentes curriculares.
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
	* HTTP/1.1 404 Not Found
	* {
	*	"status": false,
	*	"message": "Campo Obrigatorio Não Encontrado!"
	* }

    */
    

    public function add()
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('POST'),
			)
		);

		$payload = json_decode(file_get_contents('php://input'),TRUE);

		if ( isset($payload['codCompCurric']) && isset($payload['codPreRequisito'])){
			
			$componenteCurricular = $this->entity_manager->find('Entities\ComponenteCurricular', $payload['codCompCurric']);
			$preRequisito = $this->entity_manager->find('Entities\ComponenteCurricular', $payload['codPreRequisito'] );
			
			if(!is_null($componenteCurricular) && !is_null($preRequisito))
			{
                $dependencia = new Entities\Dependencia;
                //verifica se as componentes curriculares pertecem ao mesmo ppc
                if($componenteCurricular->getPpc()==$preRequisito->getPpc())
				{
                    // verifica se as componentes possuem periodos distintos
                    if($componenteCurricular->getPeriodo()!= $preRequisito->getPeriodo())
                    {
                        $dependencia->setComponenteCurricular($componenteCurricular);
                        $dependencia->setPreRequisito($preRequisito);
                        try 
                        {
                            $this->entity_manager->persist($dependencia);
                            $this->entity_manager->flush();
        
                            $this->api_return(array(
                                'status' => TRUE,
                                'message' => 'Dependencia criada com sucesso',
                            ), 200);
                        } catch (\Exception $e) {
                            $this->api_return(array(
                                'status' => false,
                                'message' => $e->getMessage(),
                            ), 400);
                        }
                    }else
                    {
                        echo "Componentes devem ter periodos distintos";
                    }
                }else
                {
                    echo " As componentes devem pertecer ao mesmo ppc"; 
                }
				

			} else {
				$this->api_return(array(
					'status' => FALSE,
					'message' => 'Campo obrigatorio não encontrado',
            ), 400);
            }
        }
    }

    public function update($codCompCurric, $codPreRequisito)
	{
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('PUT'),
            )
        );

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $dependencia = $this->entity_manager->find('Entities\Dependencia',array('componenteCurricular' => $codCompCurric, 'preRequisito' => $codPreRequisito));
        
        
        //Verifica se o corpo da requisição não é vazio
        if(!empty($payload))
        {     
            //Verifica se  existe dependencia entre as componentes curriculares 
            if(!is_null($dependencia))
            {
                //verifica se foram enviadas duas componentes curriculares para serem alteradas
                if(isset($payload['codCompCurric'],$payload['codPreRequisito']))
                {
                    $cc = $this->entity_manager->find('Entities\ComponenteCurricular',array('codCompCurric' => $payload['codCompCurric']));
                    $pr = $this->entity_manager->find('Entities\ComponenteCurricular', array('codCompCurric' => $payload['codPreRequisito']));
                    
                        //Verifica se as componentes curriculares possuem o mesmo ppc
                        if($cc->getPpc()==$pr->getPpc())
                        {                        

                            //verifica se as novas componentes possuem periodos diferentes
                            if($cc->getPeriodo()!=$pr->getPeriodo()) 
                            {
                                $dependencia->setComponenteCurricular($cc );
                                $dependencia->setPreRequisito($pr);
                                
                                try
                                {
                                    $this->entity_manager->merge($dependencia);
                                    $this->entity_manager->flush();
                                    
                                    $this->api_return(array(
                                        'status' => TRUE,
                                        'message' => 'Dependencia alterada com sucesso',
                                    ), 200);
                                } catch (\Exception $e) {
                                    $this->api_return(array(
                                        'status' => false,
                                        'message' => $e->getMessage(),
                                    ), 400);
                                }
                            }
                            else
                            {   echo "1";
                                $this->api_return(array(
                                    'status' => FALSE,
                                    'message' => 'Dependência não pode ter mesmo período',
                                ), 400);
                            }
                        }else
                        {
                            $this->api_return(array(
                                'status' => FALSE,
                                'message' => 'Dependência deve pertencer ao mesmo ppc',
                            ), 400);
                        }

                    }
                    /*caso seja enviada apenas uma componente para alteração em seguida é verificado 
                    se elas não irão pertencer ao mesmo ppc e ao mesmo periodo*/
                    else  
                    {
                        if(isset($payload['codCompCurric']))
                        { 
                            $cc = $this->entity_manager->find('Entities\ComponenteCurricular',array('codCompCurric'=>$payload['codCompCurric']));
                            $preRequisito = $this->entity_manager->find('Entities\ComponenteCurricular',array('codCompCurric' => $codPreRequisito));
                           
                            if($cc->getPpc()==$preRequisito->getPpc())
                            { 
                                if($cc->getPeriodo()!=$preRequisito->getPeriodo())
                                {
                                    $dependencia->setComponenteCurricular($cc);

                                    try
                                    {
                                        $this->entity_manager->merge($dependencia);
                                        $this->entity_manager->flush();
                                        
                                        $this->api_return(array(
                                            'status' => TRUE,
                                            'message' => 'Dependencia alterada com sucesso',
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
                                        'message' => 'Dependência não pode ter mesmo período',
                                    ), 400);
                                }
                            }else
                            {
                                $this->api_return(array(
                                    'status' => FALSE,
                                    'message' => 'Dependência deve pertencer ao mesmo ppc',
                                ), 400);
                            }
                        } 
                        if(isset($payload['codPreRequisito'])) 
                        {
                            $pr = $this->entity_manager->find('Entities\ComponenteCurricular', array('codCompCurric' => $payload['codPreRequisito']));
                            $componenteCurricular = $this->entity_manager->find('Entities\ComponenteCurricular',array('codCompCurric' => $codCompCurric));
                            
                            if($componenteCurricular->getPpc()==$pr->getPpc())
                            { 
                                if($pr->getPeriodo()!=$componenteCurricular->getPeriodo())
                                {
                                    $dependencia->setPreRequisito($pr);

                                    try
                                    {
                                        $this->entity_manager->merge($dependencia);
                                        $this->entity_manager->flush();
                                        
                                        $this->api_return(array(
                                            'status' => TRUE,
                                            'message' => 'Dependencia alterada com sucesso',
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
                                        'message' => 'Dependência não pode ter mesmo período',
                                    ), 400);
                                }
                            }else
                            {
                                $this->api_return(array(
                                    'status' => FALSE,
                                    'message' => 'Dependência deve pertencer ao mesmo ppc',
                                ), 400);
                            }
                        }

                    }            
                    
                }else 
                {
                    $this->api_return(array(
                            'status' => FALSE,
                            'message' => 'Dependência não encontrada',
                    ), 400);
                }
            }else
            {
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => 'Campo obrigatorio não encontrado',
                ), 400);
            }
    }

    public function delete($codCompCurric, $codPreRequisito)
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('GET'),
			)
		);

	
        $dependencia = $this->entity_manager->find('Entities\Dependencia',array('componenteCurricular' => $codCompCurric, 'preRequisito' => $codPreRequisito));
            
        if(!is_null($dependencia))
        {
            try
            {
                $this->entity_manager->merge($dependencia);
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