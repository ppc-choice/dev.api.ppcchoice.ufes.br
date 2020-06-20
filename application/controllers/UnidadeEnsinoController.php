<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class UnidadeEnsinoController extends APIController
{
    public function __construct() {
        parent::__construct();
    }

    /**
     * @api {get} unidades-ensino Solicitar dados de todas as unidades de ensino
     * @apiName findAll
     * @apiGroup Unidade de Ensino
     * 
     * @apiSuccess {UnidadeEnsino[]} unidadeEnsino Array de objetos do tipo Unidade de Ensino.
     * @apiSuccess {Number} unidadeEnsino[codUnidadeEnsino] Identificador único da unidade de ensino.
     * @apiSuccess {String} unidadeEnsino[nome] Nome da instituição de ensino cuja qual a unidade de ensino está vinculada.
     * 
     * @apiError {String[]} error Entities\\UnidadeEnsino: Instância não encontrada.
     */
    public function findAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));

        $groupBy = strtolower($this->input->get('groupBy'));

        if ( $groupBy === "ies" )
        { 
            $colecaoIes = $this->entityManager->getRepository('Entities\InstituicaoEnsinoSuperior')->findAll();

            if ( !empty($colecaoIes) )
            {
                $grupoUnEnsino = array();

                foreach ($colecaoIes as $key => $ies) 
                {
                    $grupoUnEnsino[$key]['instituicaoEnsino'] = $ies->getNome();
                    $grupoUnEnsino[$key]['unidadesEnsino'] = array();
                    
                    foreach ($ies->getUnidadesEnsino() as $unEnsino){
                        array_push( $grupoUnEnsino[$key]['unidadesEnsino'], $this->doctrineToArray($unEnsino, TRUE));
                    }
                }
                
                $colecaoIes = $this->doctrineToArray($grupoUnEnsino);
                
                $this->apiReturn($colecaoIes,
                    self::HTTP_OK
                );
            } else {
                $this->apiReturn(array(
                    'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
                    ), self::HTTP_NOT_FOUND
                );
            }   

        } else {
            $colecaoUnidadeEnsino = $this->entityManager->getRepository('Entities\UnidadeEnsino')->findAll();
            
            if ( !empty($colecaoUnidadeEnsino) ){
                $this->apiReturn($colecaoUnidadeEnsino,
                    self::HTTP_OK
                );
            } else {
                $this->apiReturn(array(
                    'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
                    ), self::HTTP_NOT_FOUND
                );
            }
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
     * @apiError {String[]} error Entities\\UnidadeEnsino: Instância não encontrada.
     */
    public function findById($codUnidadeEnsino)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));

        $unidadeEnsino = $this->entityManager->getRepository('Entities\UnidadeEnsino')->findById($codUnidadeEnsino);

        if ( !is_null($unidadeEnsino) ){
            $this->apiReturn($unidadeEnsino,
                self::HTTP_OK
            );
        } else {
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
                ), self::HTTP_NOT_FOUND
            );
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
     * @apiSuccess {String[]} message Entities\\UnidadeEnsino: Instância criada com sucesso.
     * 
     * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
     */
    public function create()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('POST')
        ));

        $payload = json_decode(file_get_contents('php://input'), TRUE);
        $ues = new Entities\UnidadeEnsino();
        
        if ( array_key_exists('nome', $payload) )   $ues->setNome($payload['nome']);
        if ( array_key_exists('cnpj', $payload) )   $ues->setCnpj($payload['cnpj']);

        if ( isset($payload['codIes']) ){
            $ies = $this->entityManager->find('Entities\InstituicaoEnsinoSuperior', $payload['codIes']);
            if ( !is_null($ies) ) $ues->setIes($ies);
        }

        $constraints = $this->validator->validate($ues);

        if ( $constraints->success() ){
            try {
                $this->entityManager->persist($ues);
                $this->entityManager->flush();
            
                $this->apiReturn(array(
                    'message' => $this->getApiMessage(STD_MSG_CREATED),
                    ), self::HTTP_OK
                );
                
            } catch (\Exception $e){
                $this->apiReturn(array(
                    'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
                    ), self::HTTP_BAD_REQUEST
                );
            }
        } else {
            $this->apiReturn(array(
                'error' => $constraints->messageArray(),
                ), self::HTTP_BAD_REQUEST
            );
        }
    }
    
    /**
     * @api {put} unidades-ensino/:codUnidadeEnsino Atualizar dados de uma unidade de ensino
     * @apiName update
     * @apiGroup Unidade de Ensino
     *
     * @apiParam {Number} codUnidadeEnsino Codigo único de uma unidade de ensino.
     * @apiParam (Request Body/JSON) {String} [nome] Nome da unidade de ensino.
     * @apiParam (Request Body/JSON) {String} [cnpj] CNPJ da unidade de esnino.
     * @apiParam (Request Body/JSON) {String} [codIes] Identificador único da instituição de ensino que a unidade de ensino está vinculada.
     * 
     * @apiSuccess {String[]} message Entities\\UnidadeEnsino: Instância atualizada com sucesso.
     * 
     * @apiError {String[]} error Entities\\UnidadeEnsino: Instância não encontrada.
     * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
     */
    public function update($codUnidadeEnsino)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('PUT')
        ));

        $payload = json_decode(file_get_contents('php://input'), TRUE);
        $ues = $this->entityManager->find('Entities\UnidadeEnsino', $codUnidadeEnsino);

        if ( !is_null($ues) ){
            if ( array_key_exists('nome', $payload) ) $ues->setNome($payload['nome']);
            if ( array_key_exists('cnpj', $payload) ) $ues->setCnpj($payload['cnpj']);

            if ( isset($payload['codIes']) ){
                $ies = $this->entityManager->find('Entities\InstituicaoEnsinoSuperior', $payload['codIes']);
                if ( !is_null($ies) ) $ues->setIes($ies);
            }

            $constraints = $this->validator->validate($ues);

            if($constraints->success())
            {
                try {
                    $this->entityManager->merge($ues);
                    $this->entityManager->flush();
            
                    $this->apiReturn(array(
                        'message' => $this->getApiMessage(STD_MSG_UPDATED),
                        ), self::HTTP_OK
                    );
    
                } catch (\Exception $e){
                    $this->apiReturn(array(
                        'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
                        ), self::HTTP_BAD_REQUEST
                    );
                }
            }else{
                $this->apiReturn(array(
                    'error' => $constraints->messageArray(),
                    ), self::HTTP_BAD_REQUEST
                );
            }
            
        } else {
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
                ), self::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @api {delete} unidades-ensino/:codUnidadeEnsino Excluir uma unidade de ensino
     * @apiName delete
     * @apiGroup Unidade de Ensino
     *
     * @apiParam {Number} codUnidadeEnsino Identificador único de uma unidade de ensino.
     *
     * @apiSuccess {String[]} message Entities\\UnidadeEnsino: Instância removida com sucesso.
     * 
     * @apiError {String[]} error Entities\\UnidadeEnsino: Instância não encontrada.
     * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
     */
    public function delete($codUnidadeEnsino)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('DELETE')
        ));

        $ues = $this->entityManager->find('Entities\UnidadeEnsino', $codUnidadeEnsino);

        if ( !is_null($ues) ){
            try {
                $this->entityManager->remove($ues);
                $this->entityManager->flush();

                $this->apiReturn(array(
                    'message' => $this->getApiMessage(STD_MSG_DELETED),
                    ), self::HTTP_OK
                );
            
            } catch ( \Exception $e ){
                $this->apiReturn(array(
                    'error' => $this->getApiMessage(STD_MSG_NOT_EXCEPTION),
                    ), self::HTTP_BAD_REQUEST
                );
            } 

        } else {
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
                ), self::HTTP_NOT_FOUND
            );
        }
    }
}
