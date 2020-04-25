<?php
namespace Entities\Validators;

use Symfony\Component\Validator\ExecutionContext;
use Entities\Correspondencia;
use Entities\ComponenteCurricular;
class CorrespondenciaValidator
{
    public static function ppcIgual(Correspondencia $corresp, ExecutionContext $context)
    {
        if(!is_null($corresp))
        $compCurric  = $corresp->getComponenteCurricular();
        $compCorresp = $corresp->getComponenteCurricularCorresp();
            if(!is_null($compCurric) && !is_null($compCorresp))
            {
                $ppc1 = $compCurric->getPpc()->getCodPpc();
                $ppc2 = $compCorresp->getPpc()->getCodPpc();
                if ( $ppc1 === $ppc2 ){
                    $context->addViolationAt(
                        'Correspondencia',
                        'Componentes curriculares devem ser de ppcs diferentes.',
                        array(),
                        null
                    );
                }
            }
                
    }
}