<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class UnidadeEnsinoController extends API_Controller
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

    /**
     * @api {post} unidades-ensino Cadastrar nova Unidade de Ensino no sistema
     * @apiName add
     * @apiGroup Unidades de Ensino
     * @apiError 404 Campo Obrigatório Não Encontrado
     *
     * @apiSuccess {String} nome Nome da Unidade de Ensino.
     * @apiSuccess {String} cnpj CNPJ da Unidade de Ensino.
     * @apiSuccess {Number} codIes Código da Instutuição de Ensino Superior que a Unidade de Ensino pertence.
     */
    public function add()
    {
        $this->_apiconfig(array(
            'methods' => array('POST')
        ));

        $payload = json_decode(file_get_contents('php://input'), TRUE);

        if ( isset($payload['nome']) && isset($payload['codIes']) 
                && isset($payload['cnpj'])){

            $ues = new \Entities\UnidadeEnsino;
            $ues->setNome($payload['nome']);
            $ues->setCnpj($payload['cnpj']);

            $ies = $this->entity_manager->find('Entities\InstituicaoEnsinoSuperior', $payload['codIes']);

            if ( !is_null($ies) ){
                $ues->setIes($ies);
            }

            try {
                $this->entity_manager->persist($ues);
                $this->entity_manager->flush();
    
                $this->api_return(array(
                    'status' => TRUE,
                    'result' => 'Unidade De Ensino Criada Com Sucesso',
                ), 200);
            } catch (\Exception $e){
                echo $e->getMessage();
            }

        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Campo Obrigatório Não Encontrado'
            ), 400);
        }
    }
}