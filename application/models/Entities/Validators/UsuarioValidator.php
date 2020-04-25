<?php
namespace Entities\Validators;

use Symfony\Component\Validator\ExecutionContext;
use Entities\Usuario;

class UsuarioValidator
{
    public static function contemCaracterNumerico(Usuario $author, ExecutionContext $context)
    {
        $doctrine = new \Doctrine();
        $teste = $doctrine->getEntityManager()->find('Entities\Usuario', 2);

        if ( strpos($author->getNome(),'1') ){
            $context->addViolationAt(
                'nome',
                'Nome não deve ter caracteres numéricos',
                array(),
                null
            );
        }
    }
}