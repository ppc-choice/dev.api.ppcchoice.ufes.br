<?php
namespace Entities\Validators;

use Symfony\Component\Validator\ExecutionContext;
use Entities\Correspondencia;
use Entities\Transicao;
use Doctrine;
class CorrespondenciaValidator
{
    public static function ppcIgual(Correspondencia $corresp, ExecutionContext $context)
    {
        $compCurric  = $corresp->getComponenteCurricular();
        $compCorresp = $corresp->getComponenteCurricularCorresp();
        if(!is_null($compCurric) && !is_null($compCorresp))
        {
            $ppc1 = $compCurric->getPpc()->getCodPpc();
            $ppc2 = $compCorresp->getPpc()->getCodPpc();
            if ( $ppc1 === $ppc2 ){
                $context->addViolationAt(
                    'componenteCurricular',
                    'Componentes curriculares devem ser de ppcs diferentes.',
                    array(),
                    null
                );
            }
        }
    }

    public static function transicaoInexistente(Correspondencia $corresp, ExecutionContext $context)
    {
        $compCurric  = $corresp->getComponenteCurricular();
        $compCorresp = $corresp->getComponenteCurricularCorresp();
        if(!is_null($compCurric) && !is_null($compCorresp))
        {
            $ppc1 = $compCurric->getPpc();
            $ppc2 = $compCorresp->getPpc();
            if(!is_null($ppc1) && !is_null($ppc2))
            {
                $doctrine = new \Doctrine;
                $em = $doctrine->getEntitymanager();
                $transicao = $em->find('Entities\Transicao',
                array('ppcAtual' => $ppc1->getCodPpc(), 'ppcAlvo' => $ppc2->getCodPpc()));
                if(is_null($transicao))
                {
                    $context->addViolationAt(
                        'transicao',
                        'Os Componentes curriculares devem ser de ppcs com transição mapeada entre si.',
                        array(),
                        null
                    );
                }
            }
        }
    }
}