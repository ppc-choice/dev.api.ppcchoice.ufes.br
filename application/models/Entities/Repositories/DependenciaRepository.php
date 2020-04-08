<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class DependenciaRepository extends EntityRepository
{
    public function findAll()
    {
        $qb = $this->_em->createQueryBuilder()
        ->select('curso.nome AS Curso, d.codCompCurric , disc.nome AS nomeCompCurric, d.codPreRequisito, dp.nome AS nomePreRequisito')
        ->from('Entities\Dependencia', 'd')
        ->innerJoin('d.componenteCurricular', 'cc')
        ->innerJoin('cc.disciplina', 'disc')
        ->innerJoin('d.preRequisito', 'pr')
        ->innerJoin('pr.disciplina', 'dp ') 
        ->innerJoin('cc.ppc', 'ppc')
        ->innerJoin('ppc.curso', 'curso') 
        ->getQuery();
        
        $dependencia = $qb->getResult();

        return $dependencia;
    }

    public function findById($codCompCurric, $codPreRequisito)
    {        
        $qb = $this->_em->createQueryBuilder()
        ->select('curso.nome AS Curso, d.codCompCurric , disc.nome AS nomeCompCurric, d.codPreRequisito, dp.nome AS nomePreReq')
        ->from('Entities\Dependencia', 'd')
        ->innerJoin('d.componenteCurricular', 'cc')
        ->innerJoin('cc.disciplina', 'disc')
        ->innerJoin('d.preRequisito', 'pr')
        ->innerJoin('pr.disciplina', 'dp ') 
        ->innerJoin('cc.ppc', 'ppc')
        ->innerJoin('ppc.curso', 'curso')
        ->where('d.codCompCurric = ?1 AND d.codPreRequisito = ?2')
        ->setParameters(array(1 => $codCompCurric , 2 =>$codPreRequisito))
        ->getQuery();
        
        $dependencia = $qb->getResult();
        
        return $dependencia;
    }

    public function findByIdPpc($codPpc)
    {
        $qb = $this->_em->createQueryBuilder()
        ->select('d.codCompCurric, d.codPreRequisito')
        ->from('Entities\Dependencia', 'd')
        ->innerJoin('d.componenteCurricular', 'cc')
        ->where('cc.ppc = ?1')
        ->setParameter(1,$codPpc)
        ->getQuery();
        
        $dependencia = $qb->getResult();
        
        return $dependencia;
        
    } 
}