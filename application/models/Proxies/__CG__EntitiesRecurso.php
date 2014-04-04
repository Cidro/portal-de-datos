<?php

namespace Proxies\__CG__\Entities;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Recurso extends \Entities\Recurso implements \Doctrine\ORM\Proxy\Proxy
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

    public function setCodigo($codigo)
    {
        $this->__load();
        return parent::setCodigo($codigo);
    }

    public function getCodigo()
    {
        $this->__load();
        return parent::getCodigo();
    }

    public function setDescripcion($descripcion)
    {
        $this->__load();
        return parent::setDescripcion($descripcion);
    }

    public function getDescripcion()
    {
        $this->__load();
        return parent::getDescripcion();
    }

    public function setUrl($url)
    {
        $this->__load();
        return parent::setUrl($url);
    }

    public function getUrl()
    {
        $this->__load();
        return parent::getUrl();
    }

    public function setMime($mime)
    {
        $this->__load();
        return parent::setMime($mime);
    }

    public function getMime()
    {
        $this->__load();
        return parent::getMime();
    }

    public function setSize($size)
    {
        $this->__load();
        return parent::setSize($size);
    }

    public function getSize()
    {
        $this->__load();
        return parent::getSize();
    }

    public function setCreatedAt($createdAt)
    {
        $this->__load();
        return parent::setCreatedAt($createdAt);
    }

    public function getCreatedAt()
    {
        $this->__load();
        return parent::getCreatedAt();
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->__load();
        return parent::setUpdatedAt($updatedAt);
    }

    public function getUpdatedAt()
    {
        $this->__load();
        return parent::getUpdatedAt();
    }

    public function addDescarga(\Entities\Descarga $descargas)
    {
        $this->__load();
        return parent::addDescarga($descargas);
    }

    public function getDescargas()
    {
        $this->__load();
        return parent::getDescargas();
    }

    public function setDataset(\Entities\Dataset $dataset = NULL)
    {
        $this->__load();
        return parent::setDataset($dataset);
    }

    public function getDataset()
    {
        $this->__load();
        return parent::getDataset();
    }

    public function getCopy()
    {
        $this->__load();
        return parent::getCopy();
    }

    public function fetchMetadata()
    {
        $this->__load();
        return parent::fetchMetadata();
    }

    public function validate()
    {
        $this->__load();
        return parent::validate();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'codigo', 'descripcion', 'url', 'mime', 'size', 'created_at', 'updated_at', 'descargas', 'dataset');
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
            foreach ($class->reflFields AS $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}