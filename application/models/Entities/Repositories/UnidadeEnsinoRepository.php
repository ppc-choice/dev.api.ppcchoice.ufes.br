<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class UnidadeEnsinoRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
            ->select("u.codUnidadeEnsino, CONCAT(CONCAT(CONCAT(ies.nome, ' ('), CONCAT(ies.abreviatura, ')')), CONCAT('-', u.nome)) AS nome")
            ->from('Entities\UnidadeEnsino', 'u')
            ->innerJoin('u.ies', 'ies')
            ->getQuery()
            ->getResult();
    }

    public function findbyId($codUnidadeEnsino)
    {
        return $this->_em->createQueryBuilder()
            ->select('ies.nome AS nomeInstituicao, ies.abreviatura, ies.codIes, u.nome, u.cnpj')
            ->from('Entities\UnidadeEnsino', 'u')
            ->innerJoin('u.ies', 'ies')
            ->where('u.codUnidadeEnsino = :codUnidadeEnsino')
            ->setParameter('codUnidadeEnsino',$codUnidadeEnsino)
            ->getQuery()
            ->getOneOrNullResult();
    }
}