<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class UnidadeEnsinoController extends API_Controller
{
    /**
     * @api {get} unidades-ensino Solicitar dados de todas as unidades de ensino
     * @apiName findAll
     * @apiGroup Unidade de Ensino
     * 
     * @apiSuccess {Number} codUnidadeEnsino Identificador único da unidade de ensino.
     * @apiSuccess {String} nome Nome da instituição de ensino cuja qual a unidade de ensino está vinculada.
     * 
     * @apiError {String[]} 404 Nenhuma unidade de ensino foi encontrada.
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
            ), self::HTTP_OK);
        } else {
            $this->api_return(array(
                'status' => false,
                'message' => array("Unidades de Ensino não encontradas.")
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {get} unidades-ensino/:codUnidadeEnsino Solicitar dados de uma unidade de ensino
     * @apiName findById
     * @apiGroup Unidade de Ensino
     *
     * @apiParam {Number} codUnidadeEnsino Codigo unico de uma unidade de ensino.
     *
     * @apiSuccess {String} nomeInstituicao Nome da instituição de ensino que a unidade de ensino está vinculada.
     * @apiSuccess {String} nome Nome da unidade de ensino.
     * @apiSuccess {Number} codUnEnsino Identificador único da unidade de ensino.
     * @apiSuccess {String} cnpj CNPJ da unidade de ensino.
     * @apiSuccess {Number} codIes Identificador único da instutuição de ensino que a unidade de ensino está vinculada.
     * 
     * @apiError {String[]} 404 O <code>codUnidadeEnsino</code> não corresponde a uma unidade de ensino cadastrada.
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
            ), self::HTTP_OK);
        } else {
            $this->api_return(array(
                'status' => false,
                'message' => array("Disciplina não encontrada.")
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {post} unidades-ensino Criar uma unidade de ensino
     * @apiName create
     * @apiGroup Unidade de Ensino
     *
     * @apiParam (Request Body/JSON) {String} nome Nome da unidade de ensino.
     * @apiParam (Request Body/JSON) {String} cnpj CNPJ da unidade de ensino.
     * @apiParam (Request Body/JSON) {Number} codIes Identificador único da instutuição de ensino que a unidade de ensino está vinculada.
     *
     * @apiSuccess {String} message Unidade de Ensino criada com sucesso.
     * 
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function create()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('POST')
        ));

        $payload = json_decode(file_get_contents('php://input'), TRUE);

        $ues = new \Entities\UnidadeEnsino;
        
        if ( array_key_exists('nome', $payload) )   $ues->setNome($payload['nome']);
        if ( array_key_exists('cnpj', $payload) )   $ues->setCnpj($payload['cnpj']);

        if ( array_key_exists('codIes', $payload) ){
            $ies = $this->entity_manager->find('Entities\InstituicaoEnsinoSuperior', $payload['codIes']);
            $ues->setIes($ies);
        }

        $constraints = $this->validator->validate($ues);
        if ( $constraints->count() ){
            $msgViolacoes = $constraints->messageArray();
            $this->api_return(array(
                'status' => FALSE,
                'message' => $msgViolacoes
            ), self::HTTP_BAD_REQUEST);

        } else {
            try {
                $this->entity_manager->persist($ues);
                $this->entity_manager->flush();
            
                $this->api_return(array(
                    'status' => TRUE,
                    'message' => array("Unidade de Ensino criada com sucesso."),
                ), self::HTTP_OK);
                
            } catch (\Exception $e){
                $msgExcecoes =  array($e->getMessage());
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $msgExcecoes,
                ), self::HTTP_BAD_REQUEST);
            }
        }
    }
    
    /**
     * @api {put} unidades-ensino/:codUnidadeEnsino Atualizar dados de uma unidade de ensino
     * @apiName update
     * @apiGroup Unidade de Ensino
     *
     * @apiParam {Number} codUnidadeEnsino Codigo único de uma unidade de ensino.
     * @apiParam (Request Body/JSON) {String} nome Nome da unidade de ensino.
     * @apiParam (Request Body/JSON) {String} cnpj CNPJ da unidade de esnino.
     * @apiParam (Request Body/JSON) {String} codIes Identificador único da instituição de ensino que a unidade de ensino está vinculada.
     * 
     * @apiSuccess {String} message Unidade de Ensino criada com sucesso.
     * 
     * @apiError {String[]} 404 O <code>codUnidadeEnsino</code> não corresponde a uma unidade de ensino cadastrada.
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function update($codUnidadeEnsino)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('PUT')
        ));

        $ues = $this->entity_manager->find('Entities\UnidadeEnsino', $codUnidadeEnsino);
        $payload = json_decode(file_get_contents('php://input'), TRUE);

        if ( !is_null($ues) ){
            if ( array_key_exists('codIes', $payload) ){
                $ies = $this->entity_manager->find('Entities\InstituicaoEnsinoSuperior', $payload['codIes']);
                $ues->setIes($ies);
            }

            if ( array_key_exists('nome', $payload) ) $ues->setNome($payload['nome']);
            if ( array_key_exists('cnpj', $payload) ) $ues->setCnpj($payload['cnpj']);

            $constraints = $this->validator->validate($ues);
            if($constraints->count())
            {
                $msgViolacoes = $constraints->messageArray();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $msgViolacoes
                ), self::HTTP_BAD_REQUEST);

            }else{

                try {
                    $this->entity_manager->merge($ues);
                    $this->entity_manager->flush();
            
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => array("Unidade de Ensino atualizada com sucesso."),
                    ), self::HTTP_OK);

                } catch (\Exception $e){
                    $msgExcecoes =  array($e->getMessage());
                    $this->api_return(array(
                        'status' => FALSE,
                        'message' => $msgExcecoes,
                    ), self::HTTP_BAD_REQUEST);
                }
            }
            
        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => array("Unidade de Ensino não encontrada."),
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {delete} unidades-ensino/:codUnidadeEnsino Excluir uma unidade de ensino
     * @apiName delete
     * @apiGroup Unidade de Ensino
     *
     * @apiParam {Number} codUnidadeEnsino Identificador único de uma unidade de ensino.
     *
     * @apiSuccess {String} message Unidade de Ensino deletada com sucesso.
     * 
     * @apiError {String[]} 404 O <code>codUnidadeEnsino</code> não corresponde a uma unidade de ensino cadastrada.
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function delete($codUnidadeEnsino)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('DELETE')
        ));

        $ues = $this->entity_manager->find('Entities\UnidadeEnsino', $codUnidadeEnsino);

        if ( !is_null($ues) ){
            try {
                $this->entity_manager->remove($ues);
                $this->entity_manager->flush();
                $this->api_return(array(
                    'status' => TRUE,
                    'message' => array("Unidade de Ensino deletada com sucesso.")
                ), self::HTTP_OK);
            
            } catch ( \Exception $e ){
                $msgExcecoes = array($e->getMessage());
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $msgExcecoes
                ), self::HTTP_BAD_REQUEST);
            } 

        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => "Unidade de Ensino não encontrada."
            ), self::HTTP_NOT_FOUND);
        }
    }
}