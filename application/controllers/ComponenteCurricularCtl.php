<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class ComponenteCurricularCtl extends API_Controller {

    /**
     * @api {get} componentes-curriculares/:codCompCurric Requisitar uma componente curricular
     * @apiName get
     * @apiGroup ComponenteCurricular
     *
     * @apiParam {Number} codCompCurric Codigo unico de componente curricular.
     *
     * @apiSuccess {String} nome Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {Number} periodo Número do período da componente curricular.
     * @apiSuccess {Number} credito Crédito da componente curricular.
     * @apiSuccess {Number} codDepto Código do departamento.
     * @apiSuccess {String} codDisc Código da disciplina.
     * @apiSuccess {Number} codPpc Código do projeto pedagógico de curso no qual a componente pertence.
     */
	public function get($codCompCurric)
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));

        $qb = $this->entity_manager->createQueryBuilder()
                ->select('disc.nome, c.codCompCurric, c.periodo, c.credito, c.codDepto',
                        'CONCAT(dep.abreviatura,  disc.numDisciplina) as codDisc',
                        'p.codPpc')
                ->from('Entities\ComponenteCurricular','c')
                ->innerJoin('c.disciplina','disc')
                ->innerJoin('disc.departamento','dep')
                ->innerJoin('c.ppc','p')
                ->where('c.codCompCurric =' . $codCompCurric)
                ->getQuery();
                
        $compcurric = $qb->getResult();    
     
        
        if(empty($compcurric))
        {
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Componente curricular não encontrado!'
                ),404
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $compcurric
                ),200
            );
        }
        
    }
    
    /**
     * @api {get} componentes-curriculares/ Listar todos os componentes curriculares
     * @apiName getAll
     * @apiGroup ComponenteCurricular
     *
     *
     * @apiSuccess {String} nome Nome da disciplina que o componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCurric Código do componente curricular.
     * @apiSuccess {Number} periodo Número do período do componente curricular.
     * @apiSuccess {Number} credito Crédito do componente curricular.
     * @apiSuccess {Number} codDepto Código do departamento.
     * @apiSuccess {String} codDisc Código da disciplina.
     * @apiSuccess {Number} codPpc Código do projeto pedagógico de curso no qual o componente pertence.
     */
    public function getAll()
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));

        $qb = $this->entity_manager->createQueryBuilder()
                ->select('disc.nome, c.codCompCurric, c.periodo, c.credito, c.codDepto',
                        'CONCAT(dep.abreviatura,  disc.numDisciplina) as codDisc',
                        'p.codPpc')
                ->from('Entities\ComponenteCurricular','c')
                ->innerJoin('c.disciplina','disc')
                ->innerJoin('disc.departamento','dep')
                ->innerJoin('c.ppc','p')
                ->getQuery();
                
        $compcurric = $qb->getResult();    
    
        
        if(empty($compcurric))
        {
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Nenhuma Componente curricular encontrada!'
                ),404
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $compcurric
                ),200
            );
        }
        
	}

}
