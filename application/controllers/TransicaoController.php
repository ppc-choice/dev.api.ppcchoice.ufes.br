<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class TransicaoController extends API_Controller {

    /**
     * @api {get} unidades-ensino/:codUnidadeEnsino/transicoes Listar os cursos atuais da unidade de ensino especificada para os quais há transição.
     * @apiName findByCodUnidadeEnsino
     * @apiGroup Transição
     * 
     * @apiParam {Number} codUnidadeEnsino código do ppc atual da transição desejada.
     * 
     * @apiSuccess {String} nomeCurso Nome do curso e Ano de aprovação do ppc atual da transição, no padrão: " Ciência da Computação (2011) ".
     * @apiSuccess {Number} codPpc Código do ppc atual da transição.
     * 
     * @apiError {String[]} 404 O <code>codUnidadeEnsino</code> não corresponde a uma unidade de ensino cadastrada.
     * 
     */

    public function findByCodUnidadeEnsino($codUnidadeEnsino)
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
            'methods' => array('get'),
            // 'limit' => array(2,'ip','everyday'),
            // 'requireAuthorization' => TRUE
            )
        );

        $transicao =  $this->entity_manager->getRepository('Entities\Transicao')->findByCodUnidadeEnsino($codUnidadeEnsino);


        if(!empty($transicao)){
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $transicao
                ),
                self::HTTP_OK
            );
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  array('Nenhuma transição foi encontrada para a unidade de ensino solicitada.')
                ),
                self::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @api {get} transicoes Listar todas as transições.
     * @apiName findAll
     * @apiGroup Transição
     *
     * @apiSuccess {Transicao[]} Transicoes Array de objetos do tipo transição.
     *
     * @apiError {String[]} 404 Nenhuma transição encontrada.
     */
    public function findAll()
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
            'methods' => array('GET'),
            // 'limit' => array(2,'ip','everyday'),
            // 'requireAuthorization' => TRUE
            )
        );

        $transicao = $this->entity_manager->getRepository('Entities\Transicao')->findAll();
        $retorno = $this->doctrine_to_array($transicao);
        if(!empty($transicao)){
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $retorno
                ),
                self::HTTP_OK
            );
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  array('Nenhuma transição encontrada')
                ),
                self::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @api {get} projetos-pedagogicos-curso/:codPpcAtual/transicoes Listar as transições mapeadas de um ppc.
     * @apiName findByCodPpc
     * @apiGroup Transição
     *
     * @apiParam {Number} codPpcAtual código do ppc atual da transição desejada.
     *
     * @apiSuccess {String} ppcAtual Nome do curso e Ano de aprovação do ppc atual da transição.
     * @apiSuccess {String} ppcAlvo Nome do curso e Ano de aprovação do ppc alvo da transição.
     * @apiSuccess {Number} codPpcAtual Código do ppc atual da transição.
     * @apiSuccess {Number} codPpcAlvo Código do ppc alvo da transição.
     * 
     * @apiError {String[]} 404 O <code>codPpcAtual</code> não corresponde a um ppc cadastrado.
     */
    public function findByCodPpc($codPpcAtual)
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
            'methods' => array('get'),
            // 'limit' => array(2,'ip','everyday'),
            // 'requireAuthorization' => TRUE
            )
        );

        $transicao =  $this->entity_manager->getRepository('Entities\Transicao')->findByCodPpc($codPpcAtual);


        if(!empty($transicao)){
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $transicao
                ),
                self::HTTP_OK
            );
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  array('Não foi encontrada transição para o ppc solicitado')
                ),
                self::HTTP_NOT_FOUND
            );
        }
    }


    /**
     * @api {post} transicoes Criar transição
     * @apiName create
     * @apiGroup Transição
     * 
     * @apiParam (Request Body/JSON) {String} codPpcAtual  Código do ppc atual.
     * @apiParam (Request Body/JSON) {String} codPpcAlvo  Código do ppc alvo.
     * 
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Transição criada com sucesso"
     *     }
     * 
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function create()
    {
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
            'methods' => array('POST'),
            // 'limit' => array(2,'ip','everyday'),
            // 'requireAuthorization' => TRUE
            )
        );

        $transicao = new Entities\Transicao;
        $payload = json_decode(file_get_contents('php://input'),TRUE);

        if( isset($payload['codPpcAtual']))
        {
            $ppcAtual = $this->entity_manager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpcAtual']);
            // nao tem como dar set se for null pois o metodo da entidade construida automaticamente nao
            // aceita null, e a execução da erro antes de chegar no validador
            //se nao for setado vai continuar como null e chegar no validador e continuar fluxo normal
            if(!is_null($ppcAtual)) $transicao->setPpcAtual($ppcAtual);
        }
        if( isset($payload['codPpcAlvo']))
        {
            $ppcAlvo = $this->entity_manager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpcAlvo']);
            // nao tem como dar set se for null pois o metodo da entidade construida automaticamente nao
            // aceita null, e a execução da erro antes de chegar no validador
            //se nao for setado vai continuar como null e chegar no validador e continuar fluxo normal
            if(!is_null($ppcAlvo)) $transicao->setPpcAlvo($ppcAlvo);
        }

        $validador = $this->validator->validate($transicao);
        if($validador->count())
        {
            $message = $validador->messageArray();
            $this->api_return(array(
                'status' => FALSE,
                'message' => $message
            ), self::HTTP_BAD_REQUEST);
        }else{
            try{
                $this->entity_manager->persist($transicao);
                $this->entity_manager->flush();

                $this->api_return(array(
                    'status' => TRUE,
                    'message' => array('Transição criada com sucesso.'),
                ), self::HTTP_OK);
            } catch (\Exception $e) {
                $eMsg = array($e->getMessage());
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $eMsg
                ), self::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @api {put} transicao/:codPpcAtual/:codPpcAlvo Atualizar transição
     * @apiName update
     * @apiGroup Transição
     * 
     * @apiParam {Number} codPpcAtual Código de ppc.
     * @apiParam {Number} codPpcAlvo Código de ppc.
     * @apiParam (Request Body/JSON) {String} codPpcAtual  Código do ppc atual.
     * @apiParam (Request Body/JSON) {String} codPpcAlvo  Código do ppc alvo.
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Transição atualizada com sucesso"
     *     }
     * 
     * @apiError {String[]} 404 O <code>codPpcAtual</code> ou <code>codPpcAlvo</code> não correspondem a ppc cadastrados.
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function update($codPpcAtual,$codPpcAlvo)
    {
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
            'methods' => array('PUT'),
            // 'limit' => array(2,'ip','everyday'),
            // 'requireAuthorization' => TRUE
            )
        );
        $transicao = $this->entity_manager->find('Entities\Transicao',
                array('ppcAtual' => $codPpcAtual, 'ppcAlvo' => $codPpcAlvo));
        $payload = json_decode(file_get_contents('php://input'),TRUE);
        if(!is_null($transicao))
        {
            //usar array_key_exists para tratar o caso de setar null e ser pego pelo validador
            //para gerar mensagem de erro, mas eh necessário colocar "= null" no argumento do setter
            //da chave no arquivo da entidade
            if(array_key_exists('codPpcAtual',$payload)){
                if( isset($payload['codPpcAtual']))
                    $ppcAtual = $this->entity_manager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpcAtual']);
                else{
                    $ppcAtual = null;
                } 
                $transicao->setPpcAtual($ppcAtual);
            }
            if( array_key_exists('codPpcAlvo',$payload))
            {
                if(isset($payload['codPpcAlvo']))
                    $ppcAlvo = $this->entity_manager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpcAlvo']);
                else{
                    $ppcAlvo = null;
                }
                $transicao->setPpcAlvo($ppcAlvo);
            }
            
            $validador = $this->validator->validate($transicao);
            if($validador->count())
            {
                $message = $validador->messageArray();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $message
                ), self::HTTP_BAD_REQUEST);
            }else{
                try {
                    $this->entity_manager->merge($transicao);
                    $this->entity_manager->flush();
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => array('Transição atualizada com sucesso')
                    ), self::HTTP_OK);
                } catch (\Exception $e) {
                    $eMsg = array($e->getMessage());
                    $this->api_return(array(
                        'status' => FALSE,
                        'message' => $eMsg
                    ), self::HTTP_BAD_REQUEST);
                } 
            }
        }else{
            $this->api_return(array(
                'status' => FALSE,
                'message' => array('Transição não encontrada'),
            ),self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {delete} transicoes/:codPpcAtual/:codPpcAlvo Deletar Componente Curricular
     * @apiName delete
     * @apiGroup Transição
     * 
     * @apiParam {Number} codPpcAtual Código de ppc.
     * @apiParam {Number} codPpcAlvo Código de ppc.
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Transição removida com sucesso"
     *     }
     * 
     * @apiError {String[]} 404 O <code>codPpcAtual</code> ou <code>codPpcAlvo</code> não correspondem a ppc cadastrados.
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function delete($codPpcAtual,$codPpcAlvo )
    {
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
            'methods' => array('DELETE'),
            // 'limit' => array(2,'ip','everyday'),
            // 'requireAuthorization' => TRUE
            )
        );
        $transicao = $this->entity_manager->find('Entities\Transicao',
                array('ppcAtual' => $codPpcAtual, 'ppcAlvo' => $codPpcAlvo));
        if(!is_null($transicao))
        {
            try {
                $this->entity_manager->remove($transicao);
                $this->entity_manager->flush();
                $this->api_return(array(
                    'status' => TRUE,
                    'message' => array('Transição removida com sucesso')
                ), self::HTTP_OK);
            } catch (\Exception $e) {
                $eMsg = array($e->getMessage());
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $eMsg
                ), self::HTTP_BAD_REQUEST);
            }
        }else{ 
            $this->api_return(array(
                'status' => FALSE,
                'message' => array('Transição não encontrada'),
            ),self::HTTP_NOT_FOUND);
        }
    }
}