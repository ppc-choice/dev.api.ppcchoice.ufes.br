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
            ->select('curso.codCurso, curso.nome as nomeCurso, curso.anoCriacao', 
                'uniEnsino.nome as nomeUnidadeEnsino, ies.nome as nomeIes')
            ->from('Entities\Curso','curso')
            ->innerJoin('curso.unidadeEnsino', 'uniEnsino')
            ->innerJoin('uniEnsino.ies', 'ies')
            ->getQuery()
            ->getResult();
    }
}