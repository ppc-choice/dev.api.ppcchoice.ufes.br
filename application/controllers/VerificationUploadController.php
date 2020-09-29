<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';


class VerificationUploadController extends APIController 
{
    public function __construct() {
        parent::__construct();
    }

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
			$this->apiReturn(array('message' => 'Unidade de Ensino Inválida'), self::HTTP_BAD_REQUEST);
		}

        $ppcAtual = $this->entityManager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpcAtual']);

        if ( is_null($ppcAtual) ) {
			$this->apiReturn(array('message' => 'PPC Atual Inválido'), self::HTTP_BAD_REQUEST);
		}

        $ppcAlvo = $this->entityManager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpcAlvo']);

        if ( is_null($ppcAlvo) ) {
			$this->apiReturn(array('message' => 'PPC Alvo Inválido'), self::HTTP_BAD_REQUEST);
		}

        $transicao = $this->entityManager->find('Entities\Transicao', 
            array('ppcAtual' => $payload['codPpcAtual'], 'ppcAlvo' => $payload['codPpcAlvo']));

            if ( is_null($transicao) ) {
                $this->apiReturn(array('message' => 'Transição de PPC Inválido'), self::HTTP_BAD_REQUEST);
            }

        foreach ($payload['conjuntoSelecao'] as $componente){
            $verificationComponente = $this->entityManager->find('Entities\ComponenteCurricular', $componente);

            if ( is_null($verificationComponente) ) {
                $this->apiReturn(array('message' => 'Componente Inválida'), self::HTTP_BAD_REQUEST);
            }
        }

        //  Verificar se a componente pertence ao curso atual - findBy (Verificar o retorno, talvez retorne o vetor vazio)

        // Verificar se o ppc atual pertence a unidade de ensino

        $this->apiReturn(array(
            'message' => 'Verificação feita com sucesso!',
            ), self::HTTP_OK
        );
    }

}