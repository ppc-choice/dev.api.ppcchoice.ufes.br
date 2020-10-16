<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';


class VerificationUploadController extends APIController 
{
    public function __construct() {
        parent::__construct();
    }

    /**
     * @api {post} verificacao-upload Verificar a autenticidade do arquivo JSON
     * @apiName create
     * @apiGroup Verification Upload
     *
     * @apiParam (Request Body/JSON) {String} codUnidadeEnsino Código de identificação da Unidade de Ensino.
     * @apiParam (Request Body/JSON) {String} codPpcAtual Código de identificação do Projeto Pedagógico do Curso atual.
     * @apiParam (Request Body/JSON) {String} codPpcAtual Código de identificação do Projeto Pedagógico do Curso alvo.
     * @apiParam (Request Body/JSON) {String[]} conjuntoSelecao[componentesCurriculares] Conjunto de identificadores únicos das componentes curriculares selecionadas.
     *
     * @apiSuccess {String[]} message Verificação feita com sucesso!.
     * 
     * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
     */
    public function create()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('POST'),
            )
        );

        $payload = $this->getBodyRequest();
 
        $ue = $this->entityManager->find('Entities\UnidadeEnsino', $payload['codUnidadeEnsino']);
        
        if ( is_null($ue) ) {
			$this->apiReturn(array('message' => array('Unidade de Ensino Inválida')), self::HTTP_BAD_REQUEST);
		}

        $ppcAtual = $this->entityManager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpcAtual']);

        if ( is_null($ppcAtual) ) {
			$this->apiReturn(array('message' => array('PPC Atual Inválido')), self::HTTP_BAD_REQUEST);
		}

        $ppcAlvo = $this->entityManager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpcAlvo']);

        if ( is_null($ppcAlvo) ) {
			$this->apiReturn(array('message' => array('PPC Alvo Inválido')), self::HTTP_BAD_REQUEST);
		}

        $transicao = $this->entityManager->find('Entities\Transicao', 
            array('ppcAtual' => $payload['codPpcAtual'], 'ppcAlvo' => $payload['codPpcAlvo']));

            if ( is_null($transicao) ) {
                $this->apiReturn(array('message' => array('Transição de PPC Inválido')), self::HTTP_BAD_REQUEST);
            }

        foreach ($payload['conjuntoSelecao'] as $componente){
            $verificationComponente = $this->entityManager->find('Entities\ComponenteCurricular', $componente);

            if ( is_null($verificationComponente) ) {
                $this->apiReturn(array('message' => array('Componente Inválida')), self::HTTP_BAD_REQUEST);
            }

            $compPertencePpcAtual = $this->entityManager->getRepository('Entities\ComponenteCurricular')->findOneBy(array('ppc'=> $ppcAtual, 'codCompCurric' => $componente));
            
            if ( is_null($compPertencePpcAtual) ) {
                $this->apiReturn(array('message' => array('A componente não pertence ao PPC Atual')), self::HTTP_BAD_REQUEST);
            }
        }

        // Verificar se o ppc atual pertence a unidade de ensino
        $codUes = $ppcAtual->getCurso()->getUnidadeEnsino()->getCodUnidadeEnsino();

        if ( $ue->getCodUnidadeEnsino() != $codUes) {
            $this->apiReturn(array('message' => array('O PPC Atual não pertence a Unidade de Ensino')), self::HTTP_BAD_REQUEST);
        }
        
        $this->apiReturn(array(
            'message' => array('Verificação feita com sucesso!'),
            ), self::HTTP_OK
        );
    }

}