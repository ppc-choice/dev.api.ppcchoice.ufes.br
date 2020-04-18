<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class DependenciaRepository extends EntityRepository
{
    public function findAll()
    {
        $qb = $this->_em->createQueryBuilder()
        // ->select(', d.componenteCurricular , disc.nome AS nomeCompCurric, d.preRequisito, dp.nome AS nomePreRequisito')
        ->select('curso.nome AS Curso, cc.codCompCurric, dp.nome AS nomeCompCurric, pr.codCompCurric AS codPreRequisito,  disc.nome AS nomePreRequisito')
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
        ->select('curso.nome AS Curso, cc.codCompCurric, dp.nome AS nomeCompCurric, pr.codCompCurric AS codPreRequisito,  disc.nome AS nomePreRequisito')
        ->from('Entities\Dependencia', 'd')
        ->innerJoin('d.componenteCurricular', 'cc')
        ->innerJoin('cc.disciplina', 'disc')
        ->innerJoin('d.preRequisito', 'pr')
        ->innerJoin('pr.disciplina', 'dp ') 
        ->innerJoin('cc.ppc', 'ppc')
        ->innerJoin('ppc.curso', 'curso')
        ->where('d.componenteCurricular = ?1 AND d.preRequisito = ?2')
        ->setParameters(array(1 => $codCompCurric , 2 =>$codPreRequisito))
        ->getQuery();
        
        $dependencia = $qb->getResult();
        
        return $dependencia;
    }

    public function findByIdPpc($codPpc)
    {
        $qb = $this->_em->createQueryBuilder()
        ->select('cc.codCompCurric,pr.codCompCurric AS codPreRequisito')
        ->from('Entities\Dependencia', 'd')
        ->innerJoin('d.componenteCurricular', 'cc')
        ->innerJoin('d.preRequisito', 'pr')
        ->where('cc.ppc = ?1')
        ->setParameter(1,$codPpc)
        ->getQuery();
        
        $dependencia = $qb->getResult();
        
        return $dependencia;
        
    } 
}