<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * ComponenteCurricular
 */
class ComponenteCurricular
{
    /**
     * @var integer
     */
    private $codCompCurric;

    /**
     * @var integer
     */
    private $periodo;

    /**
     * @var integer
     */
    private $credito;

    /**
     * @var string
     */
    private $tipo;

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
    private $codPpc;

    /**
     * @var \Entities\Disciplina
     */
    private $disciplina;

    /**
     * @var \Entities\ProjetoPedagogicoCurso
     */
    private $ppc;


    /**
     * Set codCompCurric
     *
     * @param integer $codCompCurric
     * @return ComponenteCurricular
     */
    public function setCodCompCurric($codCompCurric)
    {
        $this->codCompCurric = $codCompCurric;
    
        return $this;
    }

    /**
     * Get codCompCurric
     *
     * @return integer 
     */
    public function getCodCompCurric()
    {
        return $this->codCompCurric;
    }

    /**
     * Set periodo
     *
     * @param integer $periodo
     * @return ComponenteCurricular
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    
        return $this;
    }

    /**
     * Get periodo
     *
     * @return integer 
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set credito
     *
     * @param integer $credito
     * @return ComponenteCurricular
     */
    public function setCredito($credito)
    {
        $this->credito = $credito;
    
        return $this;
    }

    /**
     * Get credito
     *
     * @return integer 
     */
    public function getCredito()
    {
        return $this->credito;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return ComponenteCurricular
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codDepto
     *
     * @param integer $codDepto
     * @return ComponenteCurricular
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
     * @return ComponenteCurricular
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
     * Set codPpc
     *
     * @param integer $codPpc
     * @return ComponenteCurricular
     */
    public function setCodPpc($codPpc)
    {
        $this->codPpc = $codPpc;
    
        return $this;
    }

    /**
     * Get codPpc
     *
     * @return integer 
     */
    public function getCodPpc()
    {
        return $this->codPpc;
    }

    /**
     * Set disciplina
     *
     * @param \Entities\Disciplina $disciplina
     * @return ComponenteCurricular
     */
    public function setDisciplina(\Entities\Disciplina $disciplina = null)
    {
        $this->disciplina = $disciplina;
    
        return $this;
    }

    /**
     * Get disciplina
     *
     * @return \Entities\Disciplina 
     */
    public function getDisciplina()
    {
        return $this->disciplina;
    }

    /**
     * Set ppc
     *
     * @param \Entities\ProjetoPedagogicoCurso $ppc
     * @return ComponenteCurricular
     */
    public function setPpc(\Entities\ProjetoPedagogicoCurso $ppc = null)
    {
        $this->ppc = $ppc;
    
        return $this;
    }

    /**
     * Get ppc
     *
     * @return \Entities\ProjetoPedagogicoCurso 
     */
    public function getPpc()
    {
        return $this->ppc;
    }
}
