<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class UnidadeEnsinoRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
        ->select('i.nome, i.codIes, u.codUnidadeEnsino, u.nome, u.cnpj')
        ->from('Entities\UnidadeEnsino', 'u')
        ->innerJoin('u.ies', 'i')
        ->getQuery()
        ->getResult();
    }

    public function findbyId($codUnidadeEnsino)
    {
        return $this->_em->createQueryBuilder()
        ->select('i.codIes, u.nome, u.cnpj')
        ->from('Entities\UnidadeEnsino', 'u')
        ->innerJoin('u.ies', 'i')
        ->where('u.codUnidadeEnsino = ' . $codUnidadeEnsino)
        ->getQuery()
        ->getResult();
    }
}