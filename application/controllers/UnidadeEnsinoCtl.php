<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class UnidadeEnsinoCtl extends API_Controller
{
    /**
     * @api {get} unidades-ensino Listar todas as Unidades de Ensino
     * @apiName findAll
     * @apiGroup Unidades de Ensino
     * @apiError 404 Não encontrado
     *
     * @apiSuccess {Number} codUnidadeEnsino Código da Unidade de Ensino.
     * @apiSuccess {String} nome Nome da Instituição de Ensino cuja qual a Unidade de Ensino pertence.
     */
    public function findAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));

        $result = $this->entity_manager->getRepository('Entities\UnidadeEnsino')->findAll();
        

        if ( !empty($result) ){
            $this->api_return(array(
                'status' => true,
                'result' => $result
            ), 200);
        } else {
            $this->api_return(array(
                'status' => false,
                'message' => 'Não Encontrado'
            ), 404);
        }
    }

    /**
     * @api {get} unidades-ensino/:codUnidadeEnsino Obter Unidade de Ensino pelo códigoda dela
     * @apiName findById
     * @apiGroup Unidades de Ensino
     * @apiError 404 Não encontrado
     *
     * @apiParam {Number} codUnidadeEnsino Codigo unico de uma Unidade de Ensino.
     *
     * @apiSuccess {String} nomeInstituicao Nome da Instituição de Ensino que a Unidade de Ensino pertence.
     * @apiSuccess {String} nome Nome da Unidade de Ensino.
     * @apiSuccess {Number} codUnEnsino Código da Unidade de Ensino.
     * @apiSuccess {String} cnpj CNPJ da Unidade de Ensino.
     * @apiSuccess {Number} codIes Código da Instutuição de Ensino Superior que a Unidade de Ensino pertence.
     */
    public function findById($codUnidadeEnsino)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));

        $result = $this->entity_manager->getRepository('Entities\UnidadeEnsino')->findById($codUnidadeEnsino);

        if ( !empty($result) ){
            $this->api_return(array(
                'status' => true,
                'result' => $result
            ), 200);
        } else {
            $this->api_return(array(
                'status' => false,
                'message' => 'Não Encontrado'
            ), 404);
        }
    }
}