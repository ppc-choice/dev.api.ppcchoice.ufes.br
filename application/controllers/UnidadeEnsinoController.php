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
     * @apiName create
     * @apiGroup Unidades de Ensino
     * @apiError 400 Campo Obrigatório Não Encontrado
     * @apiError 400 Instituição de Ensino Superior Não Encontrado
     *
     * @apiSuccess {String} nome Nome da Unidade de Ensino.
     * @apiSuccess {String} cnpj CNPJ da Unidade de Ensino.
     * @apiSuccess {Number} codIes Código da Instutuição de Ensino Superior que a Unidade de Ensino pertence.
     */
    public function create()
    {
        $this->_apiconfig(array(
            'methods' => array('POST')
        ));

        $payload = json_decode(file_get_contents('php://input'), TRUE);

        if ( isset($payload['nome'], $payload['codIes'], $payload['cnpj']) ){

            // Cria novo objeto Unidade de Ensino Superior
            $ues = new \Entities\UnidadeEnsino;
            $ues->setNome($payload['nome']);
            $ues->setCnpj($payload['cnpj']);

            // Insere a Instituição de Ensino Superior do código dado.
            // Será analisado pelo validator posteriormente em caso de existência ou não.
            $ies = $this->entity_manager->find('Entities\InstituicaoEnsinoSuperior', $payload['codIes']);
            $ues->setIes($ies);

            $validador = $this->validator->validate($ues);
            if ( $validador->count() ){
                $message = $validador->messageArray();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $message
                ), 400);

            } else {
                try {
                    $this->entity_manager->persist($ues);
                    $this->entity_manager->flush();
            
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => 'Unidade De Ensino Criada Com Sucesso',
                    ), 200);
                
                } catch (\Exception $e){
                    $msg =  $e->getMessage();
                    $this->api_return(array(
                        'status' => FALSE,
                        'message' => $msg,
                    ), 400);
                }
            }

        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Campo Obrigatório Não Encontrado'
            ), 400);
        }
    }
    
    /**
     * @api {put} unidades-ensino/:codUnidadeEnsino Atualizar Unidade de Ensino específica
     * @apiName update
     * @apiGroup Unidades de Ensino
     * @apiError 404 Não encontrado
     * @apiError 400 Requisição nula
     *
     * @apiParam {Number} codUnidadeEnsino Codigo único de uma Unidade de Ensino.
     *
     * @apiSuccess {String} nome Nome da Unidade de Ensino.
     * @apiSuccess {String} cnpj CNPJ da Unidade de Esnino.
     * @apiSuccess {String} ies Instituição de Ensino Superior que a Unidade de Esnino está vinculada.
     */
    public function update($codUnidadeEnsino)
    {
        $this->_apiconfig(array(
            'methods' => array('PUT')
        ));

        $ues = $this->entity_manager->find('Entities\UnidadeEnsino', $codUnidadeEnsino);

        $payload = json_decode(file_get_contents('php://input'), TRUE);

        if ( !is_null($ues) ){

            if ( isset($payload['codIes']) ){
                $ies = $this->entity_manager->find('Entities\InstituicaoEnsinoSuperior', $payload['codIes']);
                $ues->setIes($ies);
            }

            if ( isset($payload['nome']) ) $ues->setNome($payload['nome']);
            if ( isset($payload['cnpj']) ) $ues->setCnpj($payload['cnpj']);

            $validador = $this->validator->validate($ues);
            if($validador->count())
            {
                $message = $validador->messageArray();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $message
                ), 400);

            }else{

                try {
                    $this->entity_manager->merge($ues);
                    $this->entity_manager->flush();
            
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => 'Unidade de Ensino Atualizada Com Sucesso',
                    ), 200);

                } catch (\Exception $e){
                    $e_msg =  $e->getMessage();
                    $this->api_return(array(
                        'status' => FALSE,
                        'message' => $e_msg,
                    ), 400);
                }
            }
            
        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Unidade de Ensino não encontrada',
            ), 404);
        }
    }

    /**
     * @api {delete} unidades-ensino/:codUnidadeEnsino Atualizar Unidade de Ensino específica
     * @apiName delete
     * @apiGroup Unidades de Ensino
     * @apiError 404 Não encontrado
     * @apiError 400 Requisição nula
     *
     * @apiParam {Number} codUnidadeEnsino Codigo único de uma Unidade de Ensino.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Unidade de Ensino Removida com Sucesso"
     *     }
     */
    public function delete($codUnidadeEnsino)
    {
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
                    'message' => 'Unidade de Ensino Removida com Sucesso'
                ), 200);
            
            } catch ( \Exception $e ){
                $e_msg = $e->getMessage();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $e_msg
                ), 400);
            } 

        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Unidade de Ensino não Encontrada'
            ), 404);
        }
    }
}