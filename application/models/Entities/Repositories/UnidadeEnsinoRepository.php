<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class UnidadeEnsinoRepository extends EntityRepository
{
    public function findAll()
    {
        $qb = $this->_em->createQueryBuilder()
        ->select("u.codUnidadeEnsino, CONCAT(CONCAT(CONCAT(ies.nome, ' ('), CONCAT(ies.abreviatura, ')')), CONCAT('-', u.nome)) AS nome")
            //'ies.nome AS nomeInstituicao, ies.abreviatura, ies.codIes, u.codUnidadeEnsino, u.nome, u.cnpj')
        ->from('Entities\UnidadeEnsino', 'u')
        ->innerJoin('u.ies', 'ies')
        ->getQuery();

        $result = $qb->getResult();

        return $result;
    }

    public function findbyId($codUnidadeEnsino)
    {
        $qb = $this->_em->createQueryBuilder()
        ->select('ies.nome AS nomeInstituicao, ies.abreviatura, ies.codIes, u.nome, u.cnpj')
        ->from('Entities\UnidadeEnsino', 'u')
        ->innerJoin('u.ies', 'ies')
        ->where('u.codUnidadeEnsino = ?1')
        ->setParameters(array(1 => $codUnidadeEnsino))
        ->getQuery();

        $result = $qb->getResult();

        return $result;
    }
}