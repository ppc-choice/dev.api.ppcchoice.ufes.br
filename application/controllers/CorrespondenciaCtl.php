<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class CorrespondenciaCtl extends API_Controller {

    /**
     * @api {get} projetos-pedagogicos-curso/:codPpcAtual/correspondencias/:codPpcAlvo Requisitar todas as relações de correspondência entre os cursos referidos
     * @apiName getAllByPPC
     * @apiGroup Correspondência
     *
     * @apiParam {Number} codPpcAtual Código unico do PPC atual .
     * @apiParam {Number} codPpcAlvo Código unico do PPC alvo.
     *
     * @apiSuccess {Number} codCompCurric Código da componente curricular correspondente.
     * @apiSuccess {Number} codCompCorresp Código da disciplina correspondente.
     * @apiSuccess {Number} percentual Percentual de correspondencia entre a componente e sua componente correspondente.
     */
    public function findAllByCodPpc($codPpcAtual,$codPpcAlvo)
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));
   
        $correspondencia = $this->entity_manager->getRepository('Entities\Correspondencia')->findAllByCodPpc($codPpcAtual,$codPpcAlvo);
        
        if(!empty($correspondencia))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $correspondencia
                ),200
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Correspondencias não encontradas para os PPC atual e PPC alvo informados '
                ),404
            );
        }
    }

    /**
     * @api {get} correspondencias/ Listar todas as correspondências de componentes curriculares.
     * @apiName getAll
     * @apiGroup Correspondência
     *
     *
     * @apiSuccess {String} nomeDisc Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {String} codDisc Código da disciplina.
     * @apiSuccess {String} nomeDiscCorresp Nome da disciplina correspondente que a componente correspondente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCorresp Código da componente curricular correspondente.
     * @apiSuccess {String} codDiscCorresp Código da disciplina correspondente.
     * @apiSuccess {Number} percentual Percentual de correspondencia entre a componente e sua componente correspondente.
     */
    public function findAll()
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));

                
        $correspondencia = $this->entity_manager->getRepository('Entities\Correspondencia')->findAll();
     
        
        if(!empty($correspondencia))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $correspondencia
                ),200
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Correspondência não encontrada!'
                ),404
            );
        }
    }


    /**
     * @api {get} componentes-curriculares/:codCompCurric/correspondencias Requisitar a correspondência de uma componente curricular
     * @apiName get
     * @apiGroup Correspondência
     *
     * @apiParam {Number} codCompCurric Código unico de componente curricular.
     *
     * @apiSuccess {String} nomeDisc Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {String} codDisc Código da disciplina.
     * @apiSuccess {String} nomeDiscCorresp Nome da disciplina correspondente que a componente correspondente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCorresp Código da componente curricular correspondente.
     * @apiSuccess {String} codDiscCorresp Código da disciplina correspondente.
     * @apiSuccess {Number} percentual Percentual de correspondencia entre a componente e sua componente correspondente.
     */
    public function findByCodCompCurric($codCompCurric)
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));

              
        $correspondencia = $this->entity_manager->getRepository('Entities\Correspondencia')->findByCodCompCurric($codCompCurric);


        if(!empty($correspondencia))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $correspondencia
                ),200
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Correspondência não encontrada para esta componente!'
                ),404
            );
        }
    }
}