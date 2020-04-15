
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

    public function add()
	{
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
				$dependencia->setComponenteCurricular($componenteCurricular);
				$dependencia->setPreRequisito($preRequisito);
				
				try {
					$this->entity_manager->persist($dependencia);
					$this->entity_manager->flush();

					$this->api_return(array(
						'status' => TRUE,
						'result' => 'DependenciaCriadoComSucesso',
					), 200);
				} catch (\Exception $e) {
					echo $e->getMessage();
				}

			} else {
				$this->api_return(array(
					'status' => FALSE,
					'message' => 'CampoObrigatorioNaoEncontrado',
            ), 400);
            }
        }
    }
} 