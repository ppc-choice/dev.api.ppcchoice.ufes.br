<?php
namespace Entities\Validators;

use Symfony\Component\Validator\ExecutionContext;
use Entities\Transicao;
class TransicaoValidator
{
    public static function ppcIgual(Transicao $transicao, ExecutionContext $context)
    {
        $ppcAtual = $transicao->getPpcAtual();
        $ppcAlvo = $transicao->getPpcAlvo();
        if(!is_null( $ppcAtual) && !is_null( $ppcAlvo))
        {
            $codPpcAtual = $ppcAtual->getCodPpc();
            $codPpcAlvo  = $ppcAlvo->getCodPpc();
            if ( $codPpcAtual === $codPpcAlvo ){
                $context->addViolationAt(
                    'ppcAtual',
                    'Auto-transição não é permitida.',
                    array(),
                    null
                );
            }
        }            
    }
}