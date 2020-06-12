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
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $unidadesEnsino;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->unidadesEnsino = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add unidadesEnsino
     *
     * @param \Entities\UnidadeEnsino $unidadesEnsino
     * @return InstituicaoEnsinoSuperior
     */
    public function addUnidadesEnsino(\Entities\UnidadeEnsino $unidadesEnsino)
    {
        $this->unidadesEnsino[] = $unidadesEnsino;
    
        return $this;
    }

    /**
     * Remove unidadesEnsino
     *
     * @param \Entities\UnidadeEnsino $unidadesEnsino
     */
    public function removeUnidadesEnsino(\Entities\UnidadeEnsino $unidadesEnsino)
    {
        $this->unidadesEnsino->removeElement($unidadesEnsino);
    }

    /**
     * Get unidadesEnsino
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnidadesEnsino()
    {
        return $this->unidadesEnsino;
    }
}