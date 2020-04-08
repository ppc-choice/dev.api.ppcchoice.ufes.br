<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class UnidadeEnsinoRepository extends EntityRepository
{
    public function findAll()
    {
        $qb = $this->_em->createQueryBuilder()
        ->select('i.nome AS nomeInstituicao, i.codIes, u.codUnidadeEnsino, u.nome, u.cnpj')
        ->from('Entities\UnidadeEnsino', 'u')
        ->innerJoin('u.ies', 'i')
        ->getQuery();

        $result = $qb->getResult();

        return $result;
    }

    public function findbyId($codUnidadeEnsino)
    {
        $qb = $this->_em->createQueryBuilder()
        ->select('i.nome AS nomeInstituicao, i.codIes, u.nome, u.cnpj')
        ->from('Entities\UnidadeEnsino', 'u')
        ->innerJoin('u.ies', 'i')
        ->where('u.codUnidadeEnsino = ?1')
        ->setParameters(array(1 => $codUnidadeEnsino))
        ->getQuery();

        $result = $qb->getResult();

        return $result;
    }
}