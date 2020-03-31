<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transicao
 */
class Transicao
{
    /**
     * @var integer
     */
    private $codPpcAtual;

    /**
     * @var integer
     */
    private $codPpcAlvo;

    /**
     * @var \Entities\ProjetoPedagogicoCurso
     */
    private $ppc_atual;

    /**
     * @var \Entities\ProjetoPedagogicoCurso
     */
    private $ppc_alvo;


    /**
     * Set codPpcAtual
     *
     * @param integer $codPpcAtual
     * @return Transicao
     */
    public function setCodPpcAtual($codPpcAtual)
    {
        $this->codPpcAtual = $codPpcAtual;
    
        return $this;
    }

    /**
     * Get codPpcAtual
     *
     * @return integer 
     */
    public function getCodPpcAtual()
    {
        return $this->codPpcAtual;
    }

    /**
     * Set codPpcAlvo
     *
     * @param integer $codPpcAlvo
     * @return Transicao
     */
    public function setCodPpcAlvo($codPpcAlvo)
    {
        $this->codPpcAlvo = $codPpcAlvo;
    
        return $this;
    }

    /**
     * Get codPpcAlvo
     *
     * @return integer 
     */
    public function getCodPpcAlvo()
    {
        return $this->codPpcAlvo;
    }

    /**
     * Set ppc_atual
     *
     * @param \Entities\ProjetoPedagogicoCurso $ppcAtual
     * @return Transicao
     */
    public function setPpcAtual(\Entities\ProjetoPedagogicoCurso $ppcAtual = null)
    {
        $this->ppc_atual = $ppcAtual;
    
        return $this;
    }

    /**
     * Get ppc_atual
     *
     * @return \Entities\ProjetoPedagogicoCurso 
     */
    public function getPpcAtual()
    {
        return $this->ppc_atual;
    }

    /**
     * Set ppc_alvo
     *
     * @param \Entities\ProjetoPedagogicoCurso $ppcAlvo
     * @return Transicao
     */
    public function setPpcAlvo(\Entities\ProjetoPedagogicoCurso $ppcAlvo = null)
    {
        $this->ppc_alvo = $ppcAlvo;
    
        return $this;
    }

    /**
     * Get ppc_alvo
     *
     * @return \Entities\ProjetoPedagogicoCurso 
     */
    public function getPpcAlvo()
    {
        return $this->ppc_alvo;
    }
}
