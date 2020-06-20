<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

//AUTOR: Wellerson Prenholato
class CursoRepository extends EntityRepository
{   

    public function findAll()
    {
        return $this->_em->createQueryBuilder()
            ->select('curso.codCurso, curso.nome, curso.anoCriacao', 
                'uniEnsino.codUnidadeEnsino', 'uniEnsino.nome as unidadeEnsino, instEnsinoSuperior.nome as ies')
            ->from('Entities\Curso','curso')
            ->innerJoin('curso.unidadeEnsino', 'uniEnsino')
            ->innerJoin('uniEnsino.ies', 'instEnsinoSuperior')
            ->getQuery()
            ->getResult();
    }

    public function findById($codCurso)
    {
        return $this->_em->createQueryBuilder()
            ->select('curso.codCurso, curso.nome, curso.anoCriacao', 
                'uniEnsino.codUnidadeEnsino', 'uniEnsino.nome as unidadeEnsino, instEnsinoSuperior.nome as ies')
            ->from('Entities\Curso','curso')
            ->innerJoin('curso.unidadeEnsino', 'uniEnsino')
            ->innerJoin('uniEnsino.ies', 'instEnsinoSuperior')
            ->where('curso.codCurso =:codCurso')
            ->setParameter('codCurso',$codCurso)
            ->getQuery()
            ->getOneOrNullResult();
    }
}