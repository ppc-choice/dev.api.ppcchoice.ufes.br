<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class TransicaoController extends API_Controller {

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


    /**
     * @api {post} transicoes Criar transição
     * @apiName create
     * @apiGroup Transição
     * @apiError  (Campo obrigatorio não encontrado 400) BadRequest Algum campo obrigatório não foi inserido.
     * @apiError  (PPC não encontrado 400) PPCNaoEncontrado Ppc Atual ou  Ppc Alvo não encontrado.
     * @apiParamExample {json} Request-Example:
     *     {
     *         "codPpcAtual" : 1,
	 *         "codPpcAlvo" : 4
     *     }
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Transição criada com sucesso"
     *     }
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
            ), 400);
        }else{
            try{
                $this->entity_manager->persist($transicao);
                $this->entity_manager->flush();

                $this->api_return(array(
                    'status' => TRUE,
                    'message' => 'Transição criada com sucesso.',
                ), 200);
            } catch (\Exception $e) {
                $e_msg = $e->getMessage();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $e_msg
                ), 400);
            }
        }
    }

    /**
     * @api {put} transicao/:codPpcAtual/:codPpcAlvo Atualizar transição
     * @apiName update
     * @apiGroup Transição
     * @apiParam {Number} codPpcAtual Código de ppc.
     * @apiParam {Number} codPpcAlvo Código de ppc.
     * @apiError  (Campo obrigatorio não encontrado 400) BadRequest Algum campo obrigatório não foi inserido.
     * @apiParamExample {json} Request-Example:
     *     {
     *         percentual: 0.5
     *     }
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Transição atualizada com sucesso"
     *     }
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
                ), 400);
            }else{
                try {
                    $this->entity_manager->merge($transicao);
                    $this->entity_manager->flush();
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => 'Transição atualizada com sucesso'
                    ), 200);
                } catch (\Exception $e) {
                    $e_msg = $e->getMessage();
                    $this->api_return(array(
                        'status' => FALSE,
                        'message' => $e_msg
                    ), 400);
                } 
            }
        }else{
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Transição não encontrada',
            ), 404);
        }
    }

    /**
     * @api {delete} transicoes/:codPpcAtual/:codPpcAlvo Deletar Componente Curricular
     * @apiName delete
     * @apiGroup Transição
     * @apiParam {Number} codPpcAtual Código de ppc.
     * @apiParam {Number} codPpcAlvo Código de ppc.
     * @apiError  (Campo não encontrado 400) NotFound Transição não encontrada.
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Transição removida com sucesso"
     *     }
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
                    'message' => 'Transição removida com sucesso'
                ), 200);
            } catch (\Exception $e) {
                $e_msg = $e->getMessage();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $e_msg
                ), 400);
            }
        }else{ 
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Transição não encontrada',
            ), 404);
        }
    }
}