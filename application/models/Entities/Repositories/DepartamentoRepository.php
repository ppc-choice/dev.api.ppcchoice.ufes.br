<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

//AUTOR: Wellerson Prenholato
class DepartamentoRepository extends EntityRepository
{   

    public function findAll()
    {
        return $this->_em->createQueryBuilder()
            ->select('departamento.codDepto, departamento.nome, departamento.abreviatura', 
                'uniEnsino.codUnidadeEnsino', 'uniEnsino.nome as nomeUnidadeEnsino, instEnsinoSuperior.nome as nomeIes')
            ->from('Entities\Departamento','departamento')
            ->innerJoin('departamento.unidadeEnsino', 'uniEnsino')
            ->innerJoin('uniEnsino.ies', 'instEnsinoSuperior')
            ->getQuery()
            ->getResult();
    }

    public function findById($codDepto)
    {
        return $this->_em->createQueryBuilder()
            ->select('departamento.codDepto, departamento.nome, departamento.abreviatura', 
                'uniEnsino.codUnidadeEnsino', 'uniEnsino.nome as nomeUnidadeEnsino, instEnsinoSuperior.nome as nomeIes')
            ->from('Entities\Departamento','departamento')
            ->innerJoin('departamento.unidadeEnsino', 'uniEnsino')
            ->innerJoin('uniEnsino.ies', 'instEnsinoSuperior')
            ->where('departamento.codDepto = :codDepto')
            ->setParameter('codDepto',$codDepto)
            ->getQuery()
            ->getOneOrNullResult();
    }
}