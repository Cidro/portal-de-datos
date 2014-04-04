<?php

namespace Proxies\__CG__\Entities;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Reporte extends \Entities\Reporte implements \Doctrine\ORM\Proxy\Proxy
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

    public function setEstado($estado)
    {
        $this->__load();
        return parent::setEstado($estado);
    }

    public function getEstado()
    {
        $this->__load();
        return parent::getEstado();
    }

    public function setComentarios($comentarios)
    {
        $this->__load();
        return parent::setComentarios($comentarios);
    }

    public function getComentarios()
    {
        $this->__load();
        return parent::getComentarios();
    }

    public function setNombre($nombre)
    {
        $this->__load();
        return parent::setNombre($nombre);
    }

    public function getNombre()
    {
        $this->__load();
        return parent::getNombre();
    }

    public function setEmail($email)
    {
        $this->__load();
        return parent::setEmail($email);
    }

    public function getEmail()
    {
        $this->__load();
        return parent::getEmail();
    }

    public function setTipoReporte(\Entities\TipoReporte $tipoReporte = NULL)
    {
        $this->__load();
        return parent::setTipoReporte($tipoReporte);
    }

    public function getTipoReporte()
    {
        $this->__load();
        return parent::getTipoReporte();
    }

    public function setUsuario(\Entities\User $usuario = NULL)
    {
        $this->__load();
        return parent::setUsuario($usuario);
    }

    public function getUsuario()
    {
        $this->__load();
        return parent::getUsuario();
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

    public function setOrigenPublico($origenPublico)
    {
        $this->__load();
        return parent::setOrigenPublico($origenPublico);
    }

    public function getOrigenPublico()
    {
        $this->__load();
        return parent::getOrigenPublico();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'estado', 'origen_publico', 'comentarios', 'nombre', 'email', 'created_at', 'updated_at', 'tipoReporte', 'usuario', 'dataset');
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