<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class DisciplinaRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
        ->select('d.numDisciplina, d.nome, d.ch, d.codDepto, dep.nome AS nomeDepto')
        ->from('Entities\Disciplina', 'd')
        ->innerJoin('d.departamento', 'dep')
        ->getQuery();
    }

    public function findbyId($numDisciplina)
    {
        return $this->_em->createQueryBuilder()
        ->select('d.nome, d.ch, d.codDepto, dep.nome AS nomeDep')
        ->from('Entities\Disciplina', 'd')
        ->innerJoin('d.departamento', 'dep')
        ->where('d.numDisciplina = ' . $numDisciplina)
        ->getQuery();
    }
}