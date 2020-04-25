<?php
namespace Entities\Validators;

use Symfony\Component\Validator\ExecutionContext;
use Entities\Transicao;
use Entities\ProjetoPedagogicoCurso;
class TransicaoValidator
{
    public static function ppcIgual(Transicao $transicao, ExecutionContext $context)
    {
        if(!is_null($transicao))
        {
            $ppcAtual = $transicao->getPpcAtual()->getCodPpc();
            $ppcAlvo  = $transicao->getPpcAlvo()->getCodPpc();
            if ( $ppcAtual === $ppcAlvo ){
                $context->addViolationAt(
                    'Transicao',
                    'Auto-transição não é permitida.',
                    array(),
                    null
                );
            }
        }            
    }
}