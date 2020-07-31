<?php

namespace Proxies\__CG__\Entities;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class ComponenteCurricular extends \Entities\ComponenteCurricular implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    /** @private */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    
    public function setCodCompCurric($codCompCurric)
    {
        $this->__load();
        return parent::setCodCompCurric($codCompCurric);
    }

    public function getCodCompCurric()
    {
        if ($this->__isInitialized__ === false) {
            return $this->_identifier["codCompCurric"];
        }
        $this->__load();
        return parent::getCodCompCurric();
    }

    public function setPeriodo($periodo)
    {
        $this->__load();
        return parent::setPeriodo($periodo);
    }

    public function getPeriodo()
    {
        $this->__load();
        return parent::getPeriodo();
    }

    public function setCredito($credito)
    {
        $this->__load();
        return parent::setCredito($credito);
    }

    public function getCredito()
    {
        $this->__load();
        return parent::getCredito();
    }

    public function setTipo($tipo)
    {
        $this->__load();
        return parent::setTipo($tipo);
    }

    public function getTipo()
    {
        $this->__load();
        return parent::getTipo();
    }

    public function setPosicaoColuna($posicaoColuna)
    {
        $this->__load();
        return parent::setPosicaoColuna($posicaoColuna);
    }

    public function getPosicaoColuna()
    {
        $this->__load();
        return parent::getPosicaoColuna();
    }

    public function setStyleTop($styleTop)
    {
        $this->__load();
        return parent::setStyleTop($styleTop);
    }

    public function getStyleTop()
    {
        $this->__load();
        return parent::getStyleTop();
    }

    public function setStyleLeft($styleLeft)
    {
        $this->__load();
        return parent::setStyleLeft($styleLeft);
    }

    public function getStyleLeft()
    {
        $this->__load();
        return parent::getStyleLeft();
    }

    public function setDisciplina(\Entities\Disciplina $disciplina = NULL)
    {
        $this->__load();
        return parent::setDisciplina($disciplina);
    }

    public function getDisciplina()
    {
        $this->__load();
        return parent::getDisciplina();
    }

    public function setPpc(\Entities\ProjetoPedagogicoCurso $ppc = NULL)
    {
        $this->__load();
        return parent::setPpc($ppc);
    }

    public function getPpc()
    {
        $this->__load();
        return parent::getPpc();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'codCompCurric', 'periodo', 'credito', 'tipo', 'posicaoColuna', 'styleTop', 'styleLeft', 'disciplina', 'ppc');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields as $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}