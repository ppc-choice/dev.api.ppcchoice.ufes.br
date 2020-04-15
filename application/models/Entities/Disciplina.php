<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Disciplina
 */
class Disciplina
{
    /**
     * @var integer
     */
    private $codDepto;

    /**
     * @var integer
     */
    private $numDisciplina;

    /**
     * @var integer
     */
    private $ch;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var \Entities\Departamento
     */
    private $departamento;


    /**
     * Set codDepto
     *
     * @param integer $codDepto
     * @return Disciplina
     */
    public function setCodDepto($codDepto)
    {
        $this->codDepto = $codDepto;
    
        return $this;
    }

    /**
     * Get codDepto
     *
     * @return integer 
     */
    public function getCodDepto()
    {
        return $this->codDepto;
    }

    /**
     * Set numDisciplina
     *
     * @param integer $numDisciplina
     * @return Disciplina
     */
    public function setNumDisciplina($numDisciplina)
    {
        $this->numDisciplina = $numDisciplina;
    
        return $this;
    }

    /**
     * Get numDisciplina
     *
     * @return integer 
     */
    public function getNumDisciplina()
    {
        return $this->numDisciplina;
    }

    /**
     * Set ch
     *
     * @param integer $ch
     * @return Disciplina
     */
    public function setCh($ch)
    {
        $this->ch = $ch;
    
        return $this;
    }

    /**
     * Get ch
     *
     * @return integer 
     */
    public function getCh()
    {
        return $this->ch;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Disciplina
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
     * Set departamento
     *
     * @param \Entities\Departamento $departamento
     * @return Disciplina
     */
    public function setDepartamento(\Entities\Departamento $departamento = null)
    {
        $this->departamento = $departamento;
    
        return $this;
    }

    /**
     * Get departamento
     *
     * @return \Entities\Departamento 
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }
}