<?php
namespace Entities\Validators;

use Symfony\Component\Validator\ExecutionContext;
use Entities\ProjetoPedagogicoCurso;

class ProjetoPedagogicoCursoValidator
{
    
    public static function situacaoPpc(ProjetoPedagogicoCurso $ppc, ExecutionContext $context)
    {
        $em = new \Doctrine;
        $entity_manager = $em->getEntitymanager();
        
        if(!is_null($ppc->getCurso()))
        {
            $ppcs = $entity_manager->getRepository('Entities\ProjetoPedagogicoCurso')->findByCurso($ppc->getCurso()->getCodCurso());
            
            if($ppc->getSituacao()!=STTS_PPC_INATIVO)
            {
                //Quando o codPpc é vazio é um solcitação de create e quando não é vazio é uma solicitação de update
                if(is_null($ppc->getCodPpc()))
                {
                    foreach ($ppcs as $auxppc) 
                    {
                        if(strtoupper($ppc->getSituacao())== $auxppc->getSituacao())
                        {
                            $context->addViolationAt(
                                'situacao',
                                'Não é permitido mais de um projeto pedagogico de curso com a situação ' .strtoupper($ppc->getSituacao()),
                                array(),
                                null
                            );
                            break;
                        }                    
                
                    }
                }
            }
        }
    }
        
    public static function dtTerminoVigenciaVazia(ProjetoPedagogicoCurso $ppc, ExecutionContext $context)
    {
        if($ppc->getSituacao()!=STTS_PPC_INATIVO)
        {
            if(!is_null($ppc->getDtTerminoVigencia()))
            {
                $context->addViolationAt(
                    'dtTerminoVigencia',
                    'Projeto pedagógico de curso com situação corrente e ativo-anterior a data de termino de vigência deve ser nulo.',
                    array(),
                    null
                );
            }
        }   
    }

    public static function menorData(ProjetoPedagogicoCurso $ppc, ExecutionContext $context)
    {
        if($ppc->getSituacao()==STTS_PPC_INATIVO)
        {
            if(!is_null($ppc->getDtTerminoVigencia()))
            {
                if($ppc->getDtTerminoVigencia() < $ppc->getDtInicioVigencia())
                {
                    $context->addViolationAt(
                        'dtTerminoVigencia',
                        'A data de termino de vigência deve ser maior que a data de inicio de vigência.',
                        array(),
                        null
                    );
                }
            }else{
                
                $context->addViolationAt(
                    'dtTerminoVigencia',
                    'A data de termino de vigência em projeto pedagogico de curso com situacao INATIVO não pode ser vazia.',
                    array(),
                    null
                );
            }

        }
    }
    
}
