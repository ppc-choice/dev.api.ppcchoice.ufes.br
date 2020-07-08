<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

//Autor: Hádamo
class CorrespondenciaRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
            ->select('cc1.codCompCurric as codCompCurric, dep1.abreviatura as abreviaturaDepto',
                'disc1.numDisciplina as numDisciplina, disc1.nome as nomeDisciplina, cc2.codCompCurric as codCompCurricCorresp', 
                'dep2.abreviatura as abreviaturaDeptoCorresp, disc2.numDisciplina  as numDisciplinaCorresp', 
                'disc2.nome as nomeDisciplinaCorresp, cor.percentual')
            ->from('Entities\Correspondencia','cor')
            ->innerJoin('cor.componenteCurricular','cc1')
            ->innerJoin('cc1.disciplina','disc1')
            ->innerJoin('disc1.departamento','dep1')
            ->innerJoin('cor.componenteCurricularCorresp','cc2')
            ->innerJoin('cc2.disciplina','disc2')
            ->innerJoin('disc2.departamento','dep2')
            ->orderBy('cc1.codCompCurric, cc2.codCompCurric','ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllByCodPpc($codPpcAtual,$codPpcAlvo)
    {
        return $this->_em->createQueryBuilder()
            ->select('cc1.codCompCurric as codCompCurric, cc2.codCompCurric as codCompCurricCorresp, cor.percentual')
            ->from('Entities\Correspondencia','cor')
            ->innerJoin('cor.componenteCurricular','cc1')
            ->innerJoin('cc1.ppc','ppcAtual')
            ->innerJoin('cor.componenteCurricularCorresp','cc2')
            ->innerJoin('cc2.ppc','ppcAlvo')
            ->where('ppcAtual.codPpc = :codPpcAtual AND ppcAlvo.codPpc = :codPpcAlvo')
            ->setParameters(array('codPpcAtual' => $codPpcAtual, 'codPpcAlvo' => $codPpcAlvo))
            ->orderBy('cc1.codCompCurric, cc2.codCompCurric','ASC')
            ->getQuery()
            ->getResult(); 
    }

    public function findByCodCompCurric($codCompCurric,$codCompCurricCorresp)
    {
        return $this->_em->createQueryBuilder()
            ->select('cc1.codCompCurric as codCompCurric, dep1.abreviatura as abreviaturaDepto',
                'disc1.numDisciplina as numDisciplina, disc1.nome as nomeDisciplina',
                'cc2.codCompCurric as codCompCurricCorresp, dep2.abreviatura as abreviaturaDeptoCorresp',
                'disc2.numDisciplina  as numDisciplinaCorresp, disc2.nome as nomeDisciplinaCorresp, cor.percentual')
            ->from('Entities\Correspondencia','cor')
            ->innerJoin('cor.componenteCurricular','cc1')
            ->innerJoin('cc1.disciplina','disc1')
            ->innerJoin('disc1.departamento','dep1')
            ->innerJoin('cor.componenteCurricularCorresp','cc2')
            ->innerJoin('cc2.disciplina','disc2')
            ->innerJoin('disc2.departamento','dep2')
            ->where('cc1.codCompCurric = :codCompCurric AND cc2.codCompCurric = :codCompCurricCorresp')
            ->setParameters(array('codCompCurric' => $codCompCurric, 'codCompCurricCorresp' => $codCompCurricCorresp))
            ->getQuery()
            ->getOneOrNullResult();     

    }
}