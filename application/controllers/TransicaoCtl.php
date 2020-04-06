<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class TransicaoCtl extends API_Controller {

    /**
     * @api {get} transicoes/:codPpcAtual Requisitar os cursos atuais da unidade de ensino especificada para os quais há transição.
     * @apiName getByUe
     * @apiGroup Transição
     *
     * @apiParam {Number} codPpcAtual código do ppc atual da transição desejada.
     *
     * @apiSuccess {String} nomeCurso Nome do curso e Ano de aprovação do ppc atual da transição, no padrão: " Ciência da Computação (2011) ".
     * @apiSuccess {Number} codPpc Código do ppc atual da transição.
     */

    public function getByUE($codUE)
	{
        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));

        $qb = $this->entity_manager->createQueryBuilder()
        ->select('CONCAT(c.nome, p.anoAprovacao) as nomeCurso, p.codPpc')
            ->from('Entities\Transicao','t')
            ->innerJoin('t.ppc_atual','p')
            ->innerJoin('p.curso','c')
            ->innerJoin('c.unidadeEnsino','ues1')
            ->where('ues1.codUnEnsino = :codUe'  )
            ->setParameter('codUe',$codUE )
            ->getQuery();
        
        $transicao = $qb->getResult();

        if(empty($transicao)){
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Transição não encontrada!'
                ),
                404
            );
        }else{
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $transicao
                ),
                200
            );
        }
    }

    /**
     * @api {get} transicoes/ Listar todos os componentes curriculares
     * @apiName getAll
     * @apiGroup Transição
     *
     *
     * @apiSuccess {String} ppcAtual Nome do curso e Ano de aprovação do ppc atual da transição.
     * @apiSuccess {String} ppcAlvo Nome do curso e Ano de aprovação do ppc alvo da transição.
     * @apiSuccess {Number} codPpcAtual Código do ppc atual da transição.
     * @apiSuccess {Number} codPpcAlvo Código do ppc alvo da transição.
     */
    public function getAll()
	{
        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));

        $qb = $this->entity_manager->createQueryBuilder()
            ->select('CONCAT(cAtual.nome, pAtual.anoAprovacao) as ppcAtual, t.codPpcAtual,
                    CONCAT(cAlvo.nome, pAlvo.anoAprovacao) as ppcAlvo, t.codPpcAlvo')
            ->from('Entities\Transicao','t')
            ->innerJoin('t.ppc_atual','pAtual')
            ->innerJoin('t.ppc_alvo','pAlvo')
            ->innerJoin('pAtual.curso','cAtual')
            ->innerJoin('pAlvo.curso','cAlvo')
            ->getQuery();

        $transicao = $qb->getResult();

        if(empty($transicao)){
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Nenhuma transição encontrada!'
                ),
                200
            );
        }else{
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $this->doctrine_to_array($transicao)
                ),
                200
            );
        }
    }

    /**
     * @api {get} transicoes/:codPpcAtual Requisitar uma transição de ppcs pelo código do ppc atual.
     * @apiName getByPpc
     * @apiGroup Transição
     *
     * @apiParam {Number} codPpcAtual código do ppc atual da transição desejada.
     *
     * @apiSuccess {String} ppcAtual Nome do curso e Ano de aprovação do ppc atual da transição.
     * @apiSuccess {String} ppcAlvo Nome do curso e Ano de aprovação do ppc alvo da transição.
     * @apiSuccess {Number} codPpcAtual Código do ppc atual da transição.
     * @apiSuccess {Number} codPpcAlvo Código do ppc alvo da transição.
     */
    public function getByPPC($codPpcAtual)
	{
        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));

        $qb = $this->entity_manager->createQueryBuilder()
        ->select('CONCAT(cAtual.nome, pAtual.anoAprovacao) as ppcAtual, t.codPpcAtual,
                    CONCAT(cAlvo.nome, pAlvo.anoAprovacao) as ppcAlvo, t.codPpcAlvo')
            ->from('Entities\Transicao','t')
            ->innerJoin('t.ppc_atual','pAtual')
            ->innerJoin('t.ppc_alvo','pAlvo')
            ->innerJoin('pAtual.curso','cAtual')
            ->innerJoin('pAlvo.curso','cAlvo')
            ->where('t.codPpcAtual = ' . $codPpcAtual)
            ->getQuery();
        
        $transicao = $qb->getResult();

        if(empty($transicao)){
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Transicao não encontrada!'
                ),
                404
            );
        }else{
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $transicao
                ),
                200
            );
        }
    }
}