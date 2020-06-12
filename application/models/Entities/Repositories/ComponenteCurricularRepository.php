<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

//Autor: Hádamo
class ComponenteCurricularRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
            ->select('disc.nome, c.codCompCurric, c.periodo, c.credito, c.tipo, disc.codDepto',
                    'dep.abreviatura as depto,  disc.numDisciplina, disc.ch, p.codPpc')
            ->from('Entities\ComponenteCurricular','c')
            ->innerJoin('c.disciplina','disc')
            ->innerJoin('disc.departamento','dep')
            ->innerJoin('c.ppc','p')
            ->orderBy('c.codCompCurric','ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByCodPpc($codPpc)
    {
        return $this->_em->createQueryBuilder()
            ->select('disc.nome, c.codCompCurric, c.periodo, c.credito, c.tipo, disc.codDepto',
            'dep.abreviatura as depto,  disc.numDisciplina, disc.ch, p.codPpc')
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
            ->select('disc.nome, c.codCompCurric, c.periodo, c.credito, c.tipo, disc.codDepto',
            'dep.abreviatura as depto,  disc.numDisciplina, disc.ch, p.codPpc')
            ->from('Entities\ComponenteCurricular', 'c')
            ->innerJoin('c.disciplina', 'disc')
            ->innerJoin('disc.departamento', 'dep')
            ->innerJoin('c.ppc', 'p')
            ->where('c.codCompCurric = :codCC')
            ->setParameter('codCC',$codCompCurric)
            ->getQuery()
            ->getOneOrNullResult();
    }
}