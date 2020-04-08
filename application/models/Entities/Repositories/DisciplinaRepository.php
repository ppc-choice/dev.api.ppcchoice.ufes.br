<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class DisciplinaRepository extends EntityRepository
{
    public function findAll()
    {
        $qb = $this->_em->createQueryBuilder()
        ->select('d.numDisciplina, d.nome, d.ch, d.codDepto, dep.nome AS nomeDepto')
        ->from('Entities\Disciplina', 'd')
        ->innerJoin('d.departamento', 'dep')
        ->getQuery();

        $result = $qb->getResult();

        return $result;
    }

    public function findbyId($numDisciplina, $codDepto)
    {
        $qb = $this->_em->createQueryBuilder()
        ->select('d.nome, d.ch, dep.nome AS nomeDep')
        ->from('Entities\Disciplina', 'd')
        ->innerJoin('d.departamento', 'dep')
        ->where('d.numDisciplina = ?1 AND d.codDepto = ?2')
        ->setParameters(array(1 => $numDisciplina , 2 =>$codDepto))
        ->getQuery();

        $result = $qb->getResult();

        return $result;
    }
}