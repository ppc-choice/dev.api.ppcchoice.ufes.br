<?php
namespace Entities\Validators;

use Symfony\Component\Validator\ExecutionContext;
use Entities\Dependencia;

class DependenciaValidator
{
    public static function ppcDiferente(Dependencia $dependencia, ExecutionContext $context)
    {
        if(!is_null($dependencia->getComponenteCurricular()) && !is_null($dependencia->getPreRequisito()))
        {
            if($dependencia->getComponenteCurricular()->getPpc()->getCodPpc() !=  $dependencia->getPreRequisito()->getPpc()->getCodPpc()){
                $context->addViolationAt(
                    'componenteCurricular',
                    'As componentes curriculares devem pertencer ao mesmo Projeto Pedagógico de Curso.',
                    array(),
                    null
                );
            }
        }
    }

    public static function periodoIgual(Dependencia $dependencia, ExecutionContext $context)
    {
        
        if(!is_null($dependencia->getPreRequisito() ) && !is_null($dependencia->getComponenteCurricular()))
        {
            if($dependencia->getComponenteCurricular()->getPpc()->getCodPpc() ==  $dependencia->getPreRequisito()->getPpc()->getCodPpc())
            {  
                if($dependencia->getComponenteCurricular()->getPeriodo() <= $dependencia->getPreRequisito()->getPeriodo())
                {
                    $context->addViolationAt(
                        'componenteCurricular',
                        'A componente curricular deve ter periodo maior que o seu pré-requisito.',
                        array(),
                        null
                    );
                }
            }
        }
    }

}