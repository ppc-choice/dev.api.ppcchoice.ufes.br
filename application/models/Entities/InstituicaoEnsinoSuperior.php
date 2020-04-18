<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * InstituicaoEnsinoSuperior
 */
class InstituicaoEnsinoSuperior
{
    /**
     * @var integer
     */
    private $codIes;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $abreviatura;


    /**
     * Set codIes
     *
     * @param integer $codIes
     * @return InstituicaoEnsinoSuperior
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
     * Set nome
     *
     * @param string $nome
     * @return InstituicaoEnsinoSuperior
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
     * Set abreviatura
     *
     * @param string $abreviatura
     * @return InstituicaoEnsinoSuperior
     */
    public function setAbreviatura($abreviatura)
    {
        $this->abreviatura = $abreviatura;
    
        return $this;
    }

    /**
     * Get abreviatura
     *
     * @return string 
     */
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }
}
