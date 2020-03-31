<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjetoPedagogicoCurso
 */
class ProjetoPedagogicoCurso
{
    /**
     * @var integer
     */
    private $codPpc;

    /**
     * @var \DateTime
     */
    private $dtInicioVigencia;

    /**
     * @var \DateTime
     */
    private $dtTerminoVigencia;

    /**
     * @var integer
     */
    private $chTotalDisciplinaOpt;

    /**
     * @var integer
     */
    private $chTotalDisciplinaOb;

    /**
     * @var integer
     */
    private $chTotalAtividadeExt;

    /**
     * @var integer
     */
    private $chTotalAtividadeCmplt;

    /**
     * @var integer
     */
    private $chTotalProjetoConclusao;

    /**
     * @var integer
     */
    private $chTotalEstagio;

    /**
     * @var float
     */
    private $duracao;

    /**
     * @var integer
     */
    private $qtdPeriodos;

    /**
     * @var integer
     */
    private $chTotal;

    /**
     * @var integer
     */
    private $anoAprovacao;

    /**
     * @var string
     */
    private $situacao;

    /**
     * @var \Entities\Curso
     */
    private $curso;


    /**
     * Set codPpc
     *
     * @param integer $codPpc
     * @return ProjetoPedagogicoCurso
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
     * Set dtInicioVigencia
     *
     * @param \DateTime $dtInicioVigencia
     * @return ProjetoPedagogicoCurso
     */
    public function setDtInicioVigencia($dtInicioVigencia)
    {
        $this->dtInicioVigencia = $dtInicioVigencia;
    
        return $this;
    }

    /**
     * Get dtInicioVigencia
     *
     * @return \DateTime 
     */
    public function getDtInicioVigencia()
    {
        return $this->dtInicioVigencia;
    }

    /**
     * Set dtTerminoVigencia
     *
     * @param \DateTime $dtTerminoVigencia
     * @return ProjetoPedagogicoCurso
     */
    public function setDtTerminoVigencia($dtTerminoVigencia)
    {
        $this->dtTerminoVigencia = $dtTerminoVigencia;
    
        return $this;
    }

    /**
     * Get dtTerminoVigencia
     *
     * @return \DateTime 
     */
    public function getDtTerminoVigencia()
    {
        return $this->dtTerminoVigencia;
    }

    /**
     * Set chTotalDisciplinaOpt
     *
     * @param integer $chTotalDisciplinaOpt
     * @return ProjetoPedagogicoCurso
     */
    public function setChTotalDisciplinaOpt($chTotalDisciplinaOpt)
    {
        $this->chTotalDisciplinaOpt = $chTotalDisciplinaOpt;
    
        return $this;
    }

    /**
     * Get chTotalDisciplinaOpt
     *
     * @return integer 
     */
    public function getChTotalDisciplinaOpt()
    {
        return $this->chTotalDisciplinaOpt;
    }

    /**
     * Set chTotalDisciplinaOb
     *
     * @param integer $chTotalDisciplinaOb
     * @return ProjetoPedagogicoCurso
     */
    public function setChTotalDisciplinaOb($chTotalDisciplinaOb)
    {
        $this->chTotalDisciplinaOb = $chTotalDisciplinaOb;
    
        return $this;
    }

    /**
     * Get chTotalDisciplinaOb
     *
     * @return integer 
     */
    public function getChTotalDisciplinaOb()
    {
        return $this->chTotalDisciplinaOb;
    }

    /**
     * Set chTotalAtividadeExt
     *
     * @param integer $chTotalAtividadeExt
     * @return ProjetoPedagogicoCurso
     */
    public function setChTotalAtividadeExt($chTotalAtividadeExt)
    {
        $this->chTotalAtividadeExt = $chTotalAtividadeExt;
    
        return $this;
    }

    /**
     * Get chTotalAtividadeExt
     *
     * @return integer 
     */
    public function getChTotalAtividadeExt()
    {
        return $this->chTotalAtividadeExt;
    }

    /**
     * Set chTotalAtividadeCmplt
     *
     * @param integer $chTotalAtividadeCmplt
     * @return ProjetoPedagogicoCurso
     */
    public function setChTotalAtividadeCmplt($chTotalAtividadeCmplt)
    {
        $this->chTotalAtividadeCmplt = $chTotalAtividadeCmplt;
    
        return $this;
    }

    /**
     * Get chTotalAtividadeCmplt
     *
     * @return integer 
     */
    public function getChTotalAtividadeCmplt()
    {
        return $this->chTotalAtividadeCmplt;
    }

    /**
     * Set chTotalProjetoConclusao
     *
     * @param integer $chTotalProjetoConclusao
     * @return ProjetoPedagogicoCurso
     */
    public function setChTotalProjetoConclusao($chTotalProjetoConclusao)
    {
        $this->chTotalProjetoConclusao = $chTotalProjetoConclusao;
    
        return $this;
    }

    /**
     * Get chTotalProjetoConclusao
     *
     * @return integer 
     */
    public function getChTotalProjetoConclusao()
    {
        return $this->chTotalProjetoConclusao;
    }

    /**
     * Set chTotalEstagio
     *
     * @param integer $chTotalEstagio
     * @return ProjetoPedagogicoCurso
     */
    public function setChTotalEstagio($chTotalEstagio)
    {
        $this->chTotalEstagio = $chTotalEstagio;
    
        return $this;
    }

    /**
     * Get chTotalEstagio
     *
     * @return integer 
     */
    public function getChTotalEstagio()
    {
        return $this->chTotalEstagio;
    }

    /**
     * Set duracao
     *
     * @param float $duracao
     * @return ProjetoPedagogicoCurso
     */
    public function setDuracao($duracao)
    {
        $this->duracao = $duracao;
    
        return $this;
    }

    /**
     * Get duracao
     *
     * @return float 
     */
    public function getDuracao()
    {
        return $this->duracao;
    }

    /**
     * Set qtdPeriodos
     *
     * @param integer $qtdPeriodos
     * @return ProjetoPedagogicoCurso
     */
    public function setQtdPeriodos($qtdPeriodos)
    {
        $this->qtdPeriodos = $qtdPeriodos;
    
        return $this;
    }

    /**
     * Get qtdPeriodos
     *
     * @return integer 
     */
    public function getQtdPeriodos()
    {
        return $this->qtdPeriodos;
    }

    /**
     * Set chTotal
     *
     * @param integer $chTotal
     * @return ProjetoPedagogicoCurso
     */
    public function setChTotal($chTotal)
    {
        $this->chTotal = $chTotal;
    
        return $this;
    }

    /**
     * Get chTotal
     *
     * @return integer 
     */
    public function getChTotal()
    {
        return $this->chTotal;
    }

    /**
     * Set anoAprovacao
     *
     * @param integer $anoAprovacao
     * @return ProjetoPedagogicoCurso
     */
    public function setAnoAprovacao($anoAprovacao)
    {
        $this->anoAprovacao = $anoAprovacao;
    
        return $this;
    }

    /**
     * Get anoAprovacao
     *
     * @return integer 
     */
    public function getAnoAprovacao()
    {
        return $this->anoAprovacao;
    }

    /**
     * Set situacao
     *
     * @param string $situacao
     * @return ProjetoPedagogicoCurso
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    
        return $this;
    }

    /**
     * Get situacao
     *
     * @return string 
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * Set curso
     *
     * @param \Entities\Curso $curso
     * @return ProjetoPedagogicoCurso
     */
    public function setCurso(\Entities\Curso $curso = null)
    {
        $this->curso = $curso;
    
        return $this;
    }

    /**
     * Get curso
     *
     * @return \Entities\Curso 
     */
    public function getCurso()
    {
        return $this->curso;
    }
}
