
<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @api {get} dependencias/:codCompCurric/:codPreReq Solicitar depêndencias entre componentes curriculares.
 *
 * @apiName getByid
 * @apiGroup Dependencia
 *
 * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
 * @apiSuccess {String} Nome Nome da uma componente curricular.
 * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
 * @apiSuccess {String} Nome Nome do pré-requisito da componente curricular.
 * @apiExample {curl} Exemplo:
 *      curl -i http://dev.api.ppcchoice.ufes.br/dependencias/6/1
 * @apiSuccessExample {JSON} Success-Response:
 * HHTP/1.1 200 OK
 * {
 *     nome": "Ciência da Computação",
 *     "codCompCurric": 6,
 *     "nome": "Cálculo II",
 *     "codPreRequisito": 1
 *     "nome": "Cálculo II",
 * }
*/

require_once APPPATH . 'libraries/API_Controller.php';


class DependenciaCtl extends API_Controller
{
    
    public function __construct() {
        parent::__construct();
    }
    public function getAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
           
            'methods' => array('GET'), 

        ));
        
        $qb = $this->entity_manager->createQueryBuilder()
        ->select('cs.nome, disc.nome, d.codCompCurric, d.codPreRequisito')
        ->from('Entities\Dependencia', 'd')
        ->innerjoin('d.componenteCurricular', 'cc')
        ->innerjoin('cc.ppc', 'ppc')
        ->innerjoin('ppc.curso', 'cs')
        ->leftJoin('cc.disciplina', 'disc')
        ->leftJoin('d.preRequisito', 'pr')
        ->innerJoin('pr.disciplina', 'dp ') 
        ->getQuery();
        
        $result = $qb->getResult();
        

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
                    "result" => 'Depêndencia não encontrada!',
                ),
            404);
        }
        
        
    }
    public function getById($codCompCurric, $codPreRequisito)
    {
        
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
           
            'methods' => array('GET'), 

        ));
        
        $qb = $this->entity_manager->createQueryBuilder()
        ->select('d.codCompCurric, disc.nome, d.codPreRequisito')
        ->from('Entities\Dependencia', 'd')
        ->innerJoin('d.componenteCurricular', 'cc')
        ->innerJoin('cc.disciplina', 'disc')
        ->innerJoin('d.preRequisito', 'pr')
        ->innerJoin('pr.disciplina', 'dp ') 
        ->where('d.codCompCurric = ?1 AND d.codPreRequisito = ?2')
        ->setParameters(array(1 => $codCompCurric , 2 =>$codPreRequisito))
        ->getQuery();
        
        $result = $qb->getResult();
        
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
                    "result" => 'Depêndencia não encontrada!',
                ),
            404);
        }
    }  


    public function getByIdPpc($codPpc)
    {
        
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
           
            'methods' => array('GET'), 

        ));
        
        $qb = $this->entity_manager->createQueryBuilder()
        ->select('d.codCompCurric, d.codPreRequisito')
        ->from('Entities\Dependencia', 'd')
        ->innerJoin('d.componenteCurricular', 'cc')
        ->where('cc.ppc = ?1')
        ->setParameter(1,$codPpc)
        ->getQuery();
        
        $result = $qb->getResult();
        
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
                    "result" => 'Depêndencia não encontrada!',
                ),
            404);
        }
    } 
} 