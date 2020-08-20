<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class DependenciaRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
            ->select('cs.nome AS nomeCurso, cc.codCompCurric, disc.nome AS nomeCompCurric', 
                'pr.codCompCurric AS codPreRequisito,  dp.nome AS nomePreRequisito')
            ->from('Entities\Dependencia', 'd')
            ->innerJoin('d.componenteCurricular', 'cc')
            ->innerJoin('cc.disciplina', 'disc')
            ->innerJoin('d.preRequisito', 'pr')
            ->innerJoin('pr.disciplina', 'dp ') 
            ->innerJoin('cc.ppc', 'ppc')
            ->innerJoin('ppc.curso', 'cs') 
            ->getQuery()
            ->getResult();
    }

    public function findById($codCompCurric, $codPreRequisito)
    {        
        return $this->_em->createQueryBuilder()
            ->select('curso.nome AS nomeCurso, cc.codCompCurric, disc.nome AS nomeCompCurric', 
                'pr.codCompCurric AS codPreRequisito,  dp.nome AS nomePreRequisito')
            ->from('Entities\Dependencia', 'd')
            ->innerJoin('d.componenteCurricular', 'cc')
            ->innerJoin('cc.disciplina', 'disc')
            ->innerJoin('d.preRequisito', 'pr')
            ->innerJoin('pr.disciplina', 'dp ') 
            ->innerJoin('cc.ppc', 'ppc')
            ->innerJoin('ppc.curso', 'curso')
            ->where('d.componenteCurricular = :codComponenteCurricular AND d.preRequisito = :codPreRequisito')
            ->setParameters(array('codComponenteCurricular' => $codCompCurric , 'codPreRequisito' => $codPreRequisito))
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByCodPpc($codPpc)
    {
        return $this->_em->createQueryBuilder()
            ->select('cc.codCompCurric,pr.codCompCurric AS codPreRequisito')
            ->from('Entities\Dependencia', 'd')
            ->innerJoin('d.componenteCurricular', 'cc')
            ->innerJoin('d.preRequisito', 'pr')
            ->where('cc.ppc = :codPpc')
            ->setParameter('codPpc',$codPpc)
            ->getQuery()
            ->getResult();
    } 
}