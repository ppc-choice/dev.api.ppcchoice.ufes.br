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
    private $codUnEnsino;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $cnpj;

    /**
     * @var \Entities\InstituicaoEnsinoSuperior
     */
    private $ies;


    /**
     * Set codUnEnsino
     *
     * @param integer $codUnEnsino
     * @return UnidadeEnsino
     */
    public function setCodUnEnsino($codUnEnsino)
    {
        $this->codUnEnsino = $codUnEnsino;
    
        return $this;
    }

    /**
     * Get codUnEnsino
     *
     * @return integer 
     */
    public function getCodUnEnsino()
    {
        return $this->codUnEnsino;
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
