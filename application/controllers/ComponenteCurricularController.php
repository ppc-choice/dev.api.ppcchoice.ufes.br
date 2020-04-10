<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class ComponenteCurricularController extends API_Controller {

    
    /**
     * @api {get} componentes-curriculares Listar todas as componentes curriculares
     * @apiName findAll
     * @apiGroup Componente Curricular
     * @apiError  (Componente Curricular Não Encontrada 404) ComponenteCurricularNaoEncontrada Nenhuma componente curricular encontrada.
     *
     * @apiSuccess {String} nome Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {Number} periodo Número do período da componente curricular.
     * @apiSuccess {Number} credito Crédito da componente curricular.
     * @apiSuccess {Number} codDepto Código do departamento.
     * @apiSuccess {String} codDisc Código da disciplina.
     * @apiSuccess {Number} codPpc Código do projeto pedagógico de curso no qual o componente pertence.
     */
    public function findAll()
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));
    
        $compCurric = $this->entity_manager->getRepository('Entities\ComponenteCurricular')->findAll();
        
        if(!empty($compCurric))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $compCurric
                ),200
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Nenhuma componente curricular encontrada!'
                ),404
            );
        }
        
    }
    /**
     * @api {get} projetos-pedagogicos-curso/:codPpc/componentes-curriculares Listar todas componentes curriculares de um PPC, ordenados por período e componente curricular
     * @apiName findByCodPpc
     * @apiGroup Componente Curricular
     * @apiError  (Componente Curricular Não Encontrada 404) ComponenteCurricularNaoEncontrada Não foram encontradas componentes curriculares para o ppc solicitado
     * @apiParam {Number} codPpc Código de projeto pedagógico de curso (PPC).
     * 
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {String} nome Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} ch Carga horária da disciplina da componente curricular.
     * @apiSuccess {Number} periodo Período da componente curricular.
     */
	public function findByCodPpc($codPpc)
	{
        
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));
                
        $compCurric = $this->entity_manager->getRepository('Entities\ComponenteCurricular')->findByCodPpc($codPpc);   
        
        if(!empty($compCurric))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $compCurric
                ),200
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Não foram encontradas componentes curriculares para o ppc solicitado.'
                ),404
            );
        }
    }
    
    /**
     * @api {get} componentes-curriculares/:codCompCurric Requisitar uma componente curricular
     * @apiName findByCodCompCurric
     * @apiGroup Componente Curricular
     * @apiError  (Componente Curricular Não Encontrada 404) ComponenteCurricularNaoEncontrada Componente curricular não encontrada.
     * 
     * @apiParam {Number} codCompCurric Código de componente curricular.
     *
     * @apiSuccess {String} nome Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {Number} ch Carga horária da disciplina.
     * @apiSuccess {Number} periodo Número do período da componente curricular.
     * @apiSuccess {Number} credito Crédito da componente curricular.
     * @apiSuccess {Number} codDepto Código do departamento.
     * @apiSuccess {String} codDisc Código da disciplina.
     * @apiSuccess {Number} codPpc Código do projeto pedagógico de curso o qual a componente pertence.
     */
	public function findByCodCompCurric($codCompCurric)
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));

                
        $compCurric = $this->entity_manager->getRepository('Entities\ComponenteCurricular')->findByCodCompCurric($codCompCurric);  
                
        if(!empty($compCurric))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $compCurric
                ),200
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Componente curricular não encontrada.'
                ),404
            );
        }
        
    }
    
}
