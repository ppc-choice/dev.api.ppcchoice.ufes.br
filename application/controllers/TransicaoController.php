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
     * @apiSuccess {Transicao[]} transicao Array de objetos do tipo transição.
     * @apiSuccess {String} transicao[ppcAtual] Nome do curso e ano de aprovação do ppc atual.
     * @apiSuccess {Number} transicao[codPpcAtual] Identificador único de ppc.
     * @apiSuccess {String} transicao[ppcAlvo] Nome do curso e ano de aprovação do ppc alvo.
     * @apiSuccess {Number} transicao[codPpcAlvo] Identificador único de ppc.
     *
     * @apiError {String[]} error Entities\\Transicao:    Instância não encontrada.
     */
    public function findAll()
	{
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'),
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
                    'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
                ),self::HTTP_NOT_FOUND
            );
        }
    }


    /**
     * @api {get} unidades-ensino/:codUnidadeEnsino/transicoes Listar os cursos atuais da unidade de ensino especificada para os quais há transição.
     * @apiName findByCodUnidadeEnsino
     * @apiGroup Transição
     * 
     * @apiParam {Number} codUnidadeEnsino Identificador único de unidade de ensino.
     * 
     * @apiSuccess {Transicao[]} transicao Array de objetos do tipo transição.
     * @apiSuccess {String} transicao[nomeCurso] Nome do curso e Ano de aprovação do ppc atual da transição.
     * @apiSuccess {Number} transicao[codPpc] Identificador único de ppc
     * 
     * @apiError {String[]} error Entities\\Transicao:    Instância não encontrada.
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
                    'error' =>  $this->stdMessage(STD_MSG_NOT_FOUND),
                ),self::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @api {get} projetos-pedagogicos-curso/:codPpcAtual/transicoes Listar as transições mapeadas de um ppc.
     * @apiName findByCodPpc
     * @apiGroup Transição
     *
     * @apiParam {Number} codPpcAtual Identificador único de ppc.
     *
     * @apiSuccess {Transicao[]} transicao Array de objetos do tipo transição.
     * @apiSuccess {String} transicao[ppcAtual] Nome do curso e Ano de aprovação do ppc atual da transição.
     * @apiSuccess {String} transicao[ppcAlvo] Nome do curso e Ano de aprovação do ppc alvo da transição.
     * @apiSuccess {Number} transicao[codPpcAtual] Identificador único de ppc.
     * @apiSuccess {Number} transicao[codPpcAlvo] Identificador único de ppc.
     * 
     * @apiError {String[]} error Entities\\Transicao:    Instância não encontrada.
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
                    'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
                ),self::HTTP_NOT_FOUND
            );
        }
    }


    /**
     * @api {post} transicoes Criar transição
     * @apiName create
     * @apiGroup Transição
     * 
     * @apiParam (Request Body/JSON) {Number} codPpcAtual  Identificador único de ppc.
     * @apiParam (Request Body/JSON) {Number} codPpcAlvo  Identificador único de ppc.
     * 
     * @apiSuccess {String[]} message  Entities\\Transicao: Instância criada com sucesso.
     * 
     * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
     * @apiError {String[]} error Ocorreu uma exceção ao persistir a instância.
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
                    'message' => $this->stdMessage(STD_MSG_CREATED),
                    ), self::HTTP_OK
                );
            } catch (\Exception $e) {
                $this->apiReturn(array(
                    'error' => $this->stdMessage(STD_MSG_EXCEPTION),
                    ), self::HTTP_BAD_REQUEST
                );
            }
        }else{
            $this->apiReturn(array(
                'error' => $constraints->messageArray(),
                ), self::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * @api {put} transicao/:codPpcAtual/:codPpcAlvo Atualizar transição
     * @apiName update
     * @apiGroup Transição
     * 
     * @apiParam {Number} codPpcAtual Identificador único de ppc.
     * @apiParam {Number} codPpcAlvo Identificador único de ppc.
     * @apiParam (Request Body/JSON) {Number} [codPpcAtual]  Identificador único de ppc.
     * @apiParam (Request Body/JSON) {Number} [codPpcAlvo]  Identificador único de ppc.
     * 
     * @apiSuccess {String[]} message  Entities\\Transicao: Instância atualizada com sucesso.
     * 
     * @apiError {String[]} error Entities\\Transicao:    Instância não encontrada.
     * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
     * @apiError {String[]} error Ocorreu uma exceção ao persistir a instância.
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
                        'message' => $this->stdMessage(STD_MSG_UPDATED),
                        ), self::HTTP_OK
                    );
                } catch (\Exception $e) {
                    $this->apiReturn(array(
                        'error' => $this->stdMessage(STD_MSG_EXCEPTION),
                        ), self::HTTP_BAD_REQUEST
                    );
                } 
            }else{
                $this->apiReturn(array(
                    'error' => $constraints->messageArray(),
                    ), self::HTTP_BAD_REQUEST
                );
            }
        }else{
            $this->apiReturn(array(
                'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
                ),self::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @api {delete} transicoes/:codPpcAtual/:codPpcAlvo Deletar Componente Curricular
     * @apiName delete
     * @apiGroup Transição
     * 
     * @apiParam {Number} codPpcAtual Identificador único de ppc.
     * @apiParam {Number} codPpcAlvo Identificador único de ppc.
     * 
     * @apiSuccess {String[]} message  Entities\\Transicao: Instância deletada com sucesso.
     * 
     * @apiError {String[]} error Entities\\Transicao:    Instância não encontrada.
     * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
     * @apiError {String[]} error Ocorreu uma exceção ao persistir a instância.
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
                    'message' => $this->stdMessage(STD_MSG_DELETED),
                    ), self::HTTP_OK
                );
            } catch (\Exception $e) {
                $this->apiReturn(array(
                    'error' => $this->stdMessage(STD_MSG_EXCEPTION),
                    ), self::HTTP_BAD_REQUEST
                );
            }
        }else{ 
            $this->apiReturn(array(
                'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
                ),self::HTTP_NOT_FOUND
            );
        }
    }
}