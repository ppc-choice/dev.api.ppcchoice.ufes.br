<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class TransicaoController extends APIController 
{
    public function __construct() {
        parent::__construct();
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

        $colecaoTransicao = $this->entityManager->getRepository('Entities\Transicao')->findAll();
        if(!empty($colecaoTransicao)){
            $colecaoTransicao = $this->doctrineToArray($colecaoTransicao);
            
            $this->apiReturn($colecaoTransicao,
                self::HTTP_OK
            );
        }else{
            $this->apiReturn(
                array(
                    'error' =>  array('Nenhuma transição encontrada')
                ),self::HTTP_NOT_FOUND
            );
        }
    }


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
            'methods' => array('GET'),
            )
        );

        $colecaoTransicao =  $this->entityManager->getRepository('Entities\Transicao')->findByCodUnidadeEnsino($codUnidadeEnsino);

        if(!empty($colecaoTransicao)){
            $this->apiReturn( $colecaoTransicao,
                self::HTTP_OK
            );
        }else{
            $this->apiReturn(
                array(
                    'error' =>  array('Nenhuma transição foi encontrada para a unidade de ensino solicitada.')
                ),self::HTTP_NOT_FOUND
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
            'methods' => array('GET'),
            )
        );

        $colecaoTransicao =  $this->entityManager->getRepository('Entities\Transicao')->findByCodPpc($codPpcAtual);

        if(!empty($colecaoTransicao)){
            $this->apiReturn($colecaoTransicao,
                self::HTTP_OK
            );
        }else{
            $this->apiReturn(
                array(
                    'error' =>  array('Não foi encontrada transição para o ppc solicitado')
                ),self::HTTP_NOT_FOUND
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
            )
        );

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $transicao = new Entities\Transicao();

        if( isset($payload['codPpcAtual']))
        {
            $ppcAtual = $this->entityManager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpcAtual']);
            if(!is_null($ppcAtual)) $transicao->setPpcAtual($ppcAtual);
        }
        if( isset($payload['codPpcAlvo']))
        {
            $ppcAlvo = $this->entityManager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpcAlvo']);
            if(!is_null($ppcAlvo)) $transicao->setPpcAlvo($ppcAlvo);
        }

        $constraints = $this->validator->validate($transicao);

        if($constraints->success())
        {
            try{
                $this->entityManager->persist($transicao);
                $this->entityManager->flush();

                $this->apiReturn(array(
                    'message' => array('Transição criada com sucesso.'),
                    ), self::HTTP_OK
                );
            } catch (\Exception $e) {
                $msgExcecao = array($e->getMessage());

                $this->apiReturn(array(
                    'error' => $msgExcecao
                    ), self::HTTP_BAD_REQUEST
                );
            }
        }else{
            $msgViolacoes = $constraints->messageArray();

            $this->apiReturn(array(
                'error' => $msgViolacoes
                ), self::HTTP_BAD_REQUEST
            );
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
            )
        );

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $transicao = $this->entityManager->find('Entities\Transicao',
                array('ppcAtual' => $codPpcAtual, 'ppcAlvo' => $codPpcAlvo));

        if(!is_null($transicao))
        {
            if(array_key_exists('codPpcAtual',$payload)){
                if( isset($payload['codPpcAtual'])){
                    $ppcAtual = $this->entityManager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpcAtual']);
                }else{
                    $ppcAtual = null;
                } 
                
                $transicao->setPpcAtual($ppcAtual);
            }

            if(array_key_exists('codPpcAlvo',$payload))
            {
                if(isset($payload['codPpcAlvo']))
                    $ppcAlvo = $this->entityManager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpcAlvo']);
                else{
                    $ppcAlvo = null;
                }
                $transicao->setPpcAlvo($ppcAlvo);
            }
            
            $constraints = $this->validator->validate($transicao);

            if($constraints->success())
            {
                try {
                    $this->entityManager->merge($transicao);
                    $this->entityManager->flush();

                    $this->apiReturn(array(
                        'message' => array('Transição atualizada com sucesso')
                        ), self::HTTP_OK
                    );
                } catch (\Exception $e) {
                    $msgExcecao = array($e->getMessage());

                    $this->apiReturn(array(
                        'error' => $msgExcecao
                        ), self::HTTP_BAD_REQUEST
                    );
                } 
            }else{
                $msgViolacoes = $constraints->messageArray();
             
                $this->apiReturn(array(
                    'error' => $msgViolacoes
                    ), self::HTTP_BAD_REQUEST
                );
            }
        }else{
            $this->apiReturn(array(
                'error' => array('Transição não encontrada'),
                ),self::HTTP_NOT_FOUND
            );
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
            )
        );

        $transicao = $this->entityManager->find('Entities\Transicao',
                array('ppcAtual' => $codPpcAtual, 'ppcAlvo' => $codPpcAlvo));

        if(!is_null($transicao))
        {
            try {
                $this->entityManager->remove($transicao);
                $this->entityManager->flush();

                $this->apiReturn(array(
                    'message' => array('Transição removida com sucesso')
                    ), self::HTTP_OK
                );
            } catch (\Exception $e) {
                $msgExcecao = array($e->getMessage());

                $this->apiReturn(array(
                    'error' => $msgExcecao
                    ), self::HTTP_BAD_REQUEST
                );
            }
        }else{ 
            $this->apiReturn(array(
                'error' => array('Transição não encontrada'),
                ),self::HTTP_NOT_FOUND
            );
        }
    }
}