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
    private $ppcAtual;

    /**
     * @var \Entities\ProjetoPedagogicoCurso
     */
    private $ppcAlvo;


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
     * Set ppcAtual
     *
     * @param \Entities\ProjetoPedagogicoCurso $ppcAtual
     * @return Transicao
     */
    public function setPpcAtual(\Entities\ProjetoPedagogicoCurso $ppcAtual = null)
    {
        $this->ppcAtual = $ppcAtual;
    
        return $this;
    }

    /**
     * Get ppcAtual
     *
     * @return \Entities\ProjetoPedagogicoCurso 
     */
    public function getPpcAtual()
    {
        return $this->ppcAtual;
    }

    /**
     * Set ppcAlvo
     *
     * @param \Entities\ProjetoPedagogicoCurso $ppcAlvo
     * @return Transicao
     */
    public function setPpcAlvo(\Entities\ProjetoPedagogicoCurso $ppcAlvo = null)
    {
        $this->ppcAlvo = $ppcAlvo;
    
        return $this;
    }

    /**
     * Get ppcAlvo
     *
     * @return \Entities\ProjetoPedagogicoCurso 
     */
    public function getPpcAlvo()
    {
        return $this->ppcAlvo;
    }
}
