<?php

namespace Proxies\__CG__\Entities;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class ApiKeys extends \Entities\ApiKeys implements \Doctrine\ORM\Proxy\Proxy
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

    
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int) $this->_identifier["id"];
        }
        $this->__load();
        return parent::getId();
    }

    public function setApiKey($apiKey)
    {
        $this->__load();
        return parent::setApiKey($apiKey);
    }

    public function getApiKey()
    {
        $this->__load();
        return parent::getApiKey();
    }

    public function setController($controller)
    {
        $this->__load();
        return parent::setController($controller);
    }

    public function getController()
    {
        $this->__load();
        return parent::getController();
    }

    public function setDateCreated($dateCreated)
    {
        $this->__load();
        return parent::setDateCreated($dateCreated);
    }

    public function getDateCreated()
    {
        $this->__load();
        return parent::getDateCreated();
    }

    public function setDateModified($dateModified)
    {
        $this->__load();
        return parent::setDateModified($dateModified);
    }

    public function getDateModified()
    {
        $this->__load();
        return parent::getDateModified();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'apiKey', 'controller', 'dateCreated', 'dateModified');
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