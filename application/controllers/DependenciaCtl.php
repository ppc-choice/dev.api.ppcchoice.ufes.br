
<?php defined('BASEPATH') OR exit('No direct script access allowed');



require_once APPPATH . 'libraries/API_Controller.php';


class DependenciaCtl extends API_Controller
{
    
    public function __construct() {
        parent::__construct();
    }

    /**
    * @api {get} dependencias/ Solicitar todas depêndencias existentes entre componentes curriculares.
    *
    * @apiName getAll
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
    */

    public function getAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
           
            'methods' => array('GET'), 

        ));
        
        $result = $this->entity_manager->getRepository('Entities\Dependencia')->findAll();

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
    * @api {get} dependencias/:codCompCurric/:codPreReq/ Solicitar depêndencias entre componentes curriculares.
    *
    * @apiName getById
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
    * @api {get} http://dev.api.ppcchoice.ufes.br/dependencias/:codCompCurric/:codPreRequisito
    * @apiErrorExample {json} Error-Response:
    *    HTTP/1.1 404 Not Found
    *    {
    *      status": false,
    *      "message": "Dependência não encontrado!"
    *    }
    */

    public function getById($codCompCurric, $codPreReq)
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
    * @api {get} projetos-pedagogicos-curso/:codPpc/dependencias/ Solicitar todas depêndencias entre componentes as curriculares de um Projeto Pedagógico de Curso.
    *
    * @apiName getByIdPpc
    * @apiGroup Dependência
    *
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    *
    * @apiExample {curl} Exemplo:
    *      curl -i http://dev.api.ppcchoice.ufes.br/projetos-pedagogicos-curso/1/dependencias
    * @apiSuccessExample {JSON} Success-Response:
    * HTTP/1.1 200 OK
    * 
    * {
    *     "codCompCurric": 6,
    *     "codPreRequisito": 1
    * }
    *
    * @api {get} http://dev.api.ppcchoice.ufes.br/dependencias/:codPpc
    * @apiErrorExample {json} Error-Response:
    *     HTTP/1.1 404 Not Found
    *     {
    *       status": false,
    *       "message": "Dependência não encontrado!"
    *     }
    */
    
    public function getByIdPpc($codPpc)
    {
        
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
           
            'methods' => array('GET'), 

        ));
    
        $result = $this->entity_manager->getRepository('Entities\Dependencia')->findByIdPpc($codPpc);

        
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
} 