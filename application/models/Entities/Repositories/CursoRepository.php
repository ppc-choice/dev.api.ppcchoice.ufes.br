<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

//AUTOR: Wellerson Prenholato
class CursoRepository extends EntityRepository
{   

    public function getAll()
    {
		
        $qb = $this->_em->createQueryBuilder()
             ->select('curso.codCurso, curso.nome as nomeCurso, curso.anoCriacao, uniEnsino.nome as nomeUnidadeEnsino, ies.nome as nomeIes')
             ->from('Entities\Curso','curso')
             ->leftJoin('curso.unidadeEnsino', 'uniEnsino')
             ->leftJoin('uniEnsino.ies', 'ies')
             ->getQuery();
        
        $result = $qb->getResult();
        return $result;

    }
}