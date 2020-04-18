<?php
namespace Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

//Autor: Hádamo
class TransicaoRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->_em->createQueryBuilder()
            ->select("CONCAT(CONCAT(cursoAtual.nome,' ('), CONCAT(pAtual.anoAprovacao,')')) as ppcAtual, pAtual.codPpc,
                    CONCAT(CONCAT(cursoAlvo.nome,' ('), CONCAT(pAlvo.anoAprovacao,')')) as ppcAlvo, pAlvo.codPpc")
            ->from('Entities\Transicao','t')
            ->innerJoin('t.ppcAtual','pAtual')
            ->innerJoin('t.ppcAlvo','pAlvo')
            ->innerJoin('pAtual.curso','cursoAtual')
            ->innerJoin('pAlvo.curso','cursoAlvo')
            ->getQuery()
            ->getResult();
    }

    public function findByCodUnidadeEnsino($codUnidadeEnsino)
    {
        return $this->_em->createQueryBuilder()
            ->select("CONCAT(CONCAT(c.nome,' ('), CONCAT(p.anoAprovacao,')')) as nomeCurso, p.codPpc")
            ->from('Entities\Transicao','t')
            ->innerJoin('t.ppcAtual','p')
            ->innerJoin('p.curso','c')
            ->innerJoin('c.unidadeEnsino','ues1')
            ->where('ues1.codUnidadeEnsino = :codUe'  )
            ->setParameter('codUe',$codUnidadeEnsino )
            ->getQuery()
            ->getResult();
    }

    public function findByCodPpc($codPpcAtual)
    {
        return $this->_em->createQueryBuilder()
            ->select("CONCAT(CONCAT(cursoAtual.nome,' ('), CONCAT(pAtual.anoAprovacao,')')) as ppcAtual, pAtual.codPpc,
                    CONCAT(CONCAT(cursoAlvo.nome,' ('), CONCAT(pAlvo.anoAprovacao,')')) as ppcAlvo, pAlvo.codPpc")
            ->from('Entities\Transicao','t')
            ->innerJoin('t.ppcAtual','pAtual')
            ->innerJoin('t.ppcAlvo','pAlvo')
            ->innerJoin('pAtual.curso','cursoAtual')
            ->innerJoin('pAlvo.curso','cursoAlvo')
            ->where('pAtual.codPpc = :codPpcAtual')
            ->setParameter('codPpcAtual',$codPpcAtual )
            ->getQuery()
            ->getResult();

    }
}