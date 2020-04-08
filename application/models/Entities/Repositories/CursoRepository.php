<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;


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
        //$result = $r;

        //$curso = $this->entity_manager->getRepository('Entities\Curso')->getAll(array());
        //$result = $this->doctrine_to_array($curso,TRUE);


    }
}