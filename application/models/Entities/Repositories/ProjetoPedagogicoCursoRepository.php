<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class ProjetoPedagogicoCursoRepository extends EntityRepository
{  
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
            ->select('ppc.codPpc, ppc.dtInicioVigencia, ppc.dtTerminoVigencia, ppc.chTotalDisciplinaOpt', 
                'ppc.chTotalDisciplinaOb, ppc.chTotalAtividadeExt, ppc.chTotalAtividadeCmplt', 
                'ppc.chTotalProjetoConclusao, ppc.chTotalEstagio, ppc.duracao, ppc.qtdPeriodos', 
                'ppc.chTotal, ppc.anoAprovacao, ppc.situacao, curso.codCurso')
            ->from('Entities\ProjetoPedagogicoCurso', 'ppc')
            ->innerJoin('ppc.curso', 'curso')
            ->getQuery()
            ->getResult();
    }
    
    public function findById($codPpc)
    {
        return $this->_em->createQueryBuilder()
            ->select('ppc.codPpc, ppc.dtInicioVigencia, ppc.dtTerminoVigencia, ppc.chTotalDisciplinaOpt', 
                'ppc.chTotalDisciplinaOb, ppc.chTotalAtividadeExt, ppc.chTotalAtividadeCmplt', 
                'ppc.chTotalProjetoConclusao, ppc.chTotalEstagio, ppc.duracao, ppc.qtdPeriodos', 
                'ppc.chTotal, ppc.anoAprovacao, ppc.situacao, curso.codCurso')
            ->from('Entities\ProjetoPedagogicoCurso', 'ppc')
            ->innerJoin('ppc.curso', 'curso')
            ->where('ppc = :codPpc')
            ->setParameter('codPpc',$codPpc)
            ->getQuery()
            ->getOneOrNullResult();
    } 
} 