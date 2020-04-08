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
            ->select("CONCAT(CONCAT(cAtual.nome,' ('), CONCAT(pAtual.anoAprovacao,')')) as ppcAtual, t.codPpcAtual,
                    CONCAT(CONCAT(cAlvo.nome,' ('), CONCAT(pAlvo.anoAprovacao,')')) as ppcAlvo, t.codPpcAlvo")
            ->from('Entities\Transicao','t')
            ->innerJoin('t.ppc_atual','pAtual')
            ->innerJoin('t.ppc_alvo','pAlvo')
            ->innerJoin('pAtual.curso','cAtual')
            ->innerJoin('pAlvo.curso','cAlvo')
            ->getQuery()
            ->getResult();
    }

    public function findByCodUnidadeEnsino($codUnidadeEnsino)
    {
        return $this->_em->createQueryBuilder()
            ->select("CONCAT(CONCAT(c.nome,' ('), CONCAT(p.anoAprovacao,')')) as nomeCurso, p.codPpc")
            ->from('Entities\Transicao','t')
            ->innerJoin('t.ppc_atual','p')
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
            ->select("CONCAT(CONCAT(cAtual.nome,' ('), CONCAT(pAtual.anoAprovacao,')')) as ppcAtual, t.codPpcAtual,
            CONCAT(CONCAT(cAlvo.nome,' ('), CONCAT(pAlvo.anoAprovacao,')')) as ppcAlvo, t.codPpcAlvo")
            ->from('Entities\Transicao','t')
            ->innerJoin('t.ppc_atual','pAtual')
            ->innerJoin('t.ppc_alvo','pAlvo')
            ->innerJoin('pAtual.curso','cAtual')
            ->innerJoin('pAlvo.curso','cAlvo')
            ->where('t.codPpcAtual = :codPpcAtual')
            ->setParameter('codPpcAtual',$codPpcAtual )
            ->getQuery()
            ->getResult();

    }
}