<?php
namespace Entities\Validators;

use Symfony\Component\Validator\ExecutionContext;
use Entities\Correspondencia;

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
}