<?php
namespace Entities\Validators;

use Symfony\Component\Validator\ExecutionContext;
use Entities\Dependencia;

class DependenciaValidator
{
    public static function notEqualPpc(Dependencia $dp, ExecutionContext $context)
    {
        

        if($dp->getComponenteCurricular()->getPpc()->getCodPpc() !=  $dp->getPreRequisito()->getPpc()->getCodPpc()){
            $context->addViolationAt(
                'Dependencia',
                'As componentes curriculares devem pertencer ao mesmo ppc',
                array(),
                null
            );
        }
    }

    public static function equalPeriodo(Dependencia $dp, ExecutionContext $context)
    {
        

        if($dp->getComponenteCurricular()->getPeriodo() ==  $dp->getPreRequisito()->getPeriodo()){
            $context->addViolationAt(
                'Dependencia',
                'As componentes curriculares devem ter periodos distintos',
                array(),
                null
            );
        }
    }

}