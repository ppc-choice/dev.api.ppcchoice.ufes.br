<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class TransicaoCtl extends API_Controller {

    /**
     * @api {get} unidades-ensino/:codUnidadeEnsino/transicoes Listar os cursos atuais da unidade de ensino especificada para os quais há transição.
     * @apiName findByCodUnidadeEnsino
     * @apiGroup Transição
     * @apiError  (Transição Não Encontrada 404) TransicaoNaoEncontrada  Nenhuma transição foi encontrada para os cursos da unidade de ensino solicitada.
     * 
     * @apiParam {Number} codUnidadeEnsino código do ppc atual da transição desejada.
     *
     * @apiSuccess {String} nomeCurso Nome do curso e Ano de aprovação do ppc atual da transição, no padrão: " Ciência da Computação (2011) ".
     * @apiSuccess {Number} codPpc Código do ppc atual da transição.
     */
    

    public function findByCodUnidadeEnsino($codUnidadeEnsino)
	{
        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));

        $transicao =  $this->entity_manager->getRepository('Entities\Transicao')->findByCodUnidadeEnsino($codUnidadeEnsino);


        if(!empty($transicao)){
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $transicao
                ),
                200
            );
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Nenhuma transição foi encontrada para a unidade de ensino solicitada.'
                ),
                404
            );
        }
    }

    /**
     * @api {get} transicoes Listar todas as transições.
     * @apiName findAll
     * @apiGroup Transição
     * @apiError  (Transição Não Encontrada 404) TransicaoNaoEncontrada Nenhuma transição encontrada.
     *
     * @apiSuccess {String} ppcAtual Nome do curso e Ano de aprovação do ppc atual da transição.
     * @apiSuccess {String} ppcAlvo Nome do curso e Ano de aprovação do ppc alvo da transição.
     * @apiSuccess {Number} codPpcAtual Código do ppc atual da transição.
     * @apiSuccess {Number} codPpcAlvo Código do ppc alvo da transição.
     */
    public function findAll()
	{
        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));

        $transicao = $this->entity_manager->getRepository('Entities\Transicao')->findAll();
        $retorno = $this->doctrine_to_array($transicao);
        if(!empty($transicao)){
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $retorno
                ),
                200
            );
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Nenhuma transição encontrada'
                ),
                404
            );
        }
    }

    /**
     * @api {get} projetos-pedagogicos-curso/:codPpcAtual/transicoes Listar as transições mapeadas de um ppc.
     * @apiName findByCodPpc
     * @apiGroup Transição
     * @apiError  (Transição Não Encontrada 404) TransicaoNaoEncontrada Não foi encontrada transição para o ppc solicitado.
     * @apiParam {Number} codPpcAtual código do ppc atual da transição desejada.
     *
     * @apiSuccess {String} ppcAtual Nome do curso e Ano de aprovação do ppc atual da transição.
     * @apiSuccess {String} ppcAlvo Nome do curso e Ano de aprovação do ppc alvo da transição.
     * @apiSuccess {Number} codPpcAtual Código do ppc atual da transição.
     * @apiSuccess {Number} codPpcAlvo Código do ppc alvo da transição.
     */
    public function findByCodPpc($codPpcAtual)
	{
        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));

        $transicao =  $this->entity_manager->getRepository('Entities\Transicao')->findByCodPpc($codPpcAtual);


        if(!empty($transicao)){
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $transicao
                ),
                200
            );
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Não foi encontrada transição para o ppc solicitado'
                ),
                404
            );
        }
    }
}