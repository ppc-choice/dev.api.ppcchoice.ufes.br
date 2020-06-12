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
     * @var \Entities\Disciplina
     */
    private $disciplina;

    /**
     * @var \Entities\ProjetoPedagogicoCurso
     */
    private $ppc;


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