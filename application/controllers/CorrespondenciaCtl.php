<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class CorrespondenciaCtl extends API_Controller {

    /**
     * @api {get} correspondencias/:codPpcAtual/:codPpcAlvo Requisitar todas as relações de correspondência entre os cursos referidos
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
    public function getAllByPPC($codPpcAtual,$codPpcAlvo)
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));

        $qb = $this->entity_manager->createQueryBuilder()
                ->select('cor.codCompCurric,cor.codCompCurricCorresp,cor.percentual')
                ->from('Entities\Correspondencia','cor')
                ->innerJoin('cor.componenteCurricular','cc1')
                ->innerJoin('cc1.ppc','ppcAtual')
                ->innerJoin('cor.componenteCurricularCorresp','cc2')
                ->innerJoin('cc2.ppc','ppcAlvo')
                ->where('ppcAtual.codPpc = ?1 AND ppcAlvo.codPpc = ?2')
                ->setParameters(array(1 => $codPpcAtual, 2 => $codPpcAlvo))
                ->getQuery();
                
        $correspondencia = $qb->getResult();    
     
        
        if(empty($correspondencia))
        {
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Correspondencias não encontradas para os PPC atual e PPC alvo informados '
                ),404
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $correspondencia
                ),200
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
    public function getAll()
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));

        $qb = $this->entity_manager->createQueryBuilder()
                ->select('CONCAT( dep1.abreviatura,disc1.numDisciplina) as codDisc, disc1.nome as NomeDisc, cc1.codCompCurric as codCompCurric',
                'CONCAT( dep2.abreviatura,disc2.numDisciplina) as codDiscCorresp, disc2.nome as NomeDiscCorresp, cc2.codCompCurric as codCompCorresp',
                ' cor.percentual ')
                ->from('Entities\Correspondencia','cor')
                ->innerJoin('cor.componenteCurricular','cc1')
                ->innerJoin('cc1.disciplina','disc1')
                ->innerJoin('disc1.departamento','dep1')
                ->innerJoin('cor.componenteCurricularCorresp','cc2')
                ->innerJoin('cc2.disciplina','disc2')
                ->innerJoin('disc2.departamento','dep2')
                ->getQuery();
                
        $correspondencia = $qb->getResult();    
     
        
        if(empty($correspondencia))
        {
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Correspondência não encontrada!'
                ),404
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $correspondencia
                ),200
            );
        }
    }


    /**
     * @api {get} correspondencias/:codCompCurric Requisitar a correspondência de uma componente curricular
     * @apiName get
     * @apiGroup Correspondência
     *
     * @apiParam {Number} codCompCurric Codigo unico de componente curricular.
     *
     * @apiSuccess {String} nomeDisc Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {String} codDisc Código da disciplina.
     * @apiSuccess {String} nomeDiscCorresp Nome da disciplina correspondente que a componente correspondente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCorresp Código da componente curricular correspondente.
     * @apiSuccess {String} codDiscCorresp Código da disciplina correspondente.
     * @apiSuccess {Number} percentual Percentual de correspondencia entre a componente e sua componente correspondente.
     */
    public function getByCC($codCompCurric)
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));

        $qb = $this->entity_manager->createQueryBuilder()
                ->select('CONCAT( dep1.abreviatura,disc1.numDisciplina) as codDisc, disc1.nome as NomeDisc, cc1.codCompCurric as codCompCurric',
                'CONCAT( dep2.abreviatura,disc2.numDisciplina) as codDiscCorresp, disc2.nome as NomeDiscCorresp, cc2.codCompCurric as codCompCorresp',
                ' cor.percentual ')
                ->from('Entities\Correspondencia','cor')
                ->innerJoin('cor.componenteCurricular','cc1')
                ->innerJoin('cc1.disciplina','disc1')
                ->innerJoin('disc1.departamento','dep1')
                ->innerJoin('cor.componenteCurricularCorresp','cc2')
                ->innerJoin('cc2.disciplina','disc2')
                ->innerJoin('disc2.departamento','dep2')
                ->where('cc1.codCompCurric = :codCC OR cc2.codCompCurric = :codCC')
                ->setParameter('codCC',$codCompCurric)
                ->getQuery();
                
        $correspondencia = $qb->getResult();    
     
        
        if(empty($correspondencia))
        {
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Correspondência não encontrada para esta componente!'
                ),404
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $correspondencia
                ),200
            );
        }
    }
}