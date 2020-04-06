<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;


class CorrespondenciaRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
                ->select('cc1.codCompCurric as codCompCurric, dep1.abreviatura as depto,disc1.numDisciplina as numDisc, disc1.nome as NomeDisc',
                'cc2.codCompCurric as codCompCorresp, dep2.abreviatura as deptoDiscCorresp,disc2.numDisciplina  as numDiscCorresp, disc2.nome as NomeDiscCorresp',
                ' cor.percentual ')
                ->from('Entities\Correspondencia','cor')
                ->innerJoin('cor.componenteCurricular','cc1')
                ->innerJoin('cc1.disciplina','disc1')
                ->innerJoin('disc1.departamento','dep1')
                ->innerJoin('cor.componenteCurricularCorresp','cc2')
                ->innerJoin('cc2.disciplina','disc2')
                ->innerJoin('disc2.departamento','dep2')
                ->getQuery()
                ->getResult();
       
    }

    public function findAllByCodPpc($codPpcAtual,$codPpcAlvo)
    {
        return $this->_em->createQueryBuilder()
                ->select('cor.codCompCurric,cor.codCompCurricCorresp,cor.percentual')
                ->from('Entities\Correspondencia','cor')
                ->innerJoin('cor.componenteCurricular','cc1')
                ->innerJoin('cc1.ppc','ppcAtual')
                ->innerJoin('cor.componenteCurricularCorresp','cc2')
                ->innerJoin('cc2.ppc','ppcAlvo')
                ->where('ppcAtual.codPpc = ?1 AND ppcAlvo.codPpc = ?2')
                ->setParameters(array(1 => $codPpcAtual, 2 => $codPpcAlvo))
                ->getQuery()
                ->getResult(); 
    }

    public function findByCodCompCurric($codCompCurric)
    {
        return $this->_em->createQueryBuilder()
            ->select('cc1.codCompCurric as codCompCurric, dep1.abreviatura as depto,disc1.numDisciplina as numDisc, disc1.nome as NomeDisc',
            'cc2.codCompCurric as codCompCorresp, dep2.abreviatura as deptoDiscCorresp,disc2.numDisciplina  as numDiscCorresp, disc2.nome as NomeDiscCorresp',
            ' cor.percentual ')
                ->from('Entities\Correspondencia','cor')
                ->innerJoin('cor.componenteCurricular','cc1')
                ->innerJoin('cc1.disciplina','disc1')
                ->innerJoin('disc1.departamento','dep1')
                ->innerJoin('cor.componenteCurricularCorresp','cc2')
                ->innerJoin('cc2.disciplina','disc2')
                ->innerJoin('disc2.departamento','dep2')
                ->where('cc1.codCompCurric = :codCC OR cc2.codCompCurric = :codCC')
                ->setParameter('codCC',$codCompCurric)
                ->getQuery()
                ->getResult();     
    }
}