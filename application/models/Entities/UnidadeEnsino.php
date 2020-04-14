<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnidadeEnsino
 */
class UnidadeEnsino
{
    /**
     * @var integer
     */
    private $codUnidadeEnsino;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $cnpj;

    /**
     * @var integer
     */
    private $codIes;

    /**
     * @var \Entities\InstituicaoEnsinoSuperior
     */
    private $ies;


    /**
     * Set codUnidadeEnsino
     *
     * @param integer $codUnidadeEnsino
     * @return UnidadeEnsino
     */
    public function setCodUnidadeEnsino($codUnidadeEnsino)
    {
        $this->codUnidadeEnsino = $codUnidadeEnsino;
    
        return $this;
    }

    /**
     * Get codUnidadeEnsino
     *
     * @return integer 
     */
    public function getCodUnidadeEnsino()
    {
        return $this->codUnidadeEnsino;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return UnidadeEnsino
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    
        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set cnpj
     *
     * @param string $cnpj
     * @return UnidadeEnsino
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    
        return $this;
    }

    /**
     * Get cnpj
     *
     * @return string 
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Set codIes
     *
     * @param integer $codIes
     * @return UnidadeEnsino
     */
    public function setCodIes($codIes)
    {
        $this->codIes = $codIes;
    
        return $this;
    }

    /**
     * Get codIes
     *
     * @return integer 
     */
    public function getCodIes()
    {
        return $this->codIes;
    }

    /**
     * Set ies
     *
     * @param \Entities\InstituicaoEnsinoSuperior $ies
     * @return UnidadeEnsino
     */
    public function setIes(\Entities\InstituicaoEnsinoSuperior $ies = null)
    {
        $this->ies = $ies;
    
        return $this;
    }

    /**
     * Get ies
     *
     * @return \Entities\InstituicaoEnsinoSuperior 
     */
    public function getIes()
    {
        return $this->ies;
    }
}
