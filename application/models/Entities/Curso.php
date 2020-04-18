<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Curso
 */
class Curso
{
    /**
     * @var integer
     */
    private $codCurso;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var integer
     */
    private $anoCriacao;

    /**
     * @var \Entities\UnidadeEnsino
     */
    private $unidadeEnsino;


    /**
     * Get codCurso
     *
     * @return integer 
     */
    public function getCodCurso()
    {
        return $this->codCurso;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Curso
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
     * Set anoCriacao
     *
     * @param integer $anoCriacao
     * @return Curso
     */
    public function setAnoCriacao($anoCriacao)
    {
        $this->anoCriacao = $anoCriacao;
    
        return $this;
    }

    /**
     * Get anoCriacao
     *
     * @return integer 
     */
    public function getAnoCriacao()
    {
        return $this->anoCriacao;
    }

    /**
     * Set unidadeEnsino
     *
     * @param \Entities\UnidadeEnsino $unidadeEnsino
     * @return Curso
     */
    public function setUnidadeEnsino(\Entities\UnidadeEnsino $unidadeEnsino = null)
    {
        $this->unidadeEnsino = $unidadeEnsino;
    
        return $this;
    }

    /**
     * Get unidadeEnsino
     *
     * @return \Entities\UnidadeEnsino 
     */
    public function getUnidadeEnsino()
    {
        return $this->unidadeEnsino;
    }
}
