<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class DisciplinaRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
            ->select('d.numDisciplina, d.nome, d.ch, d.codDepto, dep.abreviatura AS abreviaturaDepto')
            ->from('Entities\Disciplina', 'd')
            ->innerJoin('d.departamento', 'dep')
            ->getQuery()
            ->getResult();
    }

    public function findbyId($numDisciplina, $codDepto)
    {
        return $this->_em->createQueryBuilder()
            ->select('d.nome, d.ch, dep.nome AS nomeDepto')
            ->from('Entities\Disciplina', 'd')
            ->innerJoin('d.departamento', 'dep')
            ->where('d.numDisciplina = :numDisciplina AND d.codDepto = :codDepto')
            ->setParameters(array('numDisciplina' => $numDisciplina , 'codDepto' => $codDepto))
            ->getQuery()
            ->getOneOrNullResult();
    }
}