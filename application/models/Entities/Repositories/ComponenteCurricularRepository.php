<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;


class ComponenteCurricularRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
                ->select('disc.nome, c.codCompCurric, c.periodo, c.credito, c.codDepto',
                        'dep.abreviatura as depto,  disc.numDisciplina',
                        'p.codPpc')
                ->from('Entities\ComponenteCurricular','c')
                ->innerJoin('c.disciplina','disc')
                ->innerJoin('disc.departamento','dep')
                ->innerJoin('c.ppc','p')
                ->getQuery()
                ->getResult();
    }

    public function findByCodPpc($codPpc)
    {
        return $this->_em->createQueryBuilder()
                ->select('c.codCompCurric, disc.nome, disc.ch, c.tipo, c.periodo ')
                ->from('Entities\ComponenteCurricular','c')
                ->innerJoin('c.disciplina','disc')
                ->innerJoin('disc.departamento','dep')
                ->innerJoin('c.ppc','p')
                ->where('p.codPpc = :codPpc')
                ->setParameter('codPpc', $codPpc)
                ->orderBy('c.periodo,c.codCompCurric','ASC')
                ->getQuery()
                ->getResult();
    }

    public function findByCodCompCurric($codCompCurric)
    {
        return $this->_em->createQueryBuilder()
            ->select('disc.nome, c.codCompCurric,disc.ch, c.periodo, c.credito, c.codDepto',
                    'dep.abreviatura as depto,  disc.numDisciplina',
                    'p.codPpc')
            ->from('Entities\ComponenteCurricular','c')
            ->innerJoin('c.disciplina','disc')
            ->innerJoin('disc.departamento','dep')
            ->innerJoin('c.ppc','p')
            ->where('c.codCompCurric = :codCC')
            ->setParameter('codCC',$codCompCurric)
            ->getQuery()
            ->getResult();
    }
}