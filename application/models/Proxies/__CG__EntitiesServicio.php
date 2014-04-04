<?php

namespace Proxies\__CG__\Entities;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Servicio extends \Entities\Servicio implements \Doctrine\ORM\Proxy\Proxy
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

    
    public function setCodigo($codigo)
    {
        $this->__load();
        return parent::setCodigo($codigo);
    }

    public function getCodigo()
    {
        if ($this->__isInitialized__ === false) {
            return $this->_identifier["codigo"];
        }
        $this->__load();
        return parent::getCodigo();
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

    public function setSigla($sigla)
    {
        $this->__load();
        return parent::setSigla($sigla);
    }

    public function getSigla()
    {
        $this->__load();
        return parent::getSigla();
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

    public function setOficial($oficial)
    {
        $this->__load();
        return parent::setOficial($oficial);
    }

    public function getOficial()
    {
        $this->__load();
        return parent::getOficial();
    }

    public function setPublicado($publicado)
    {
        $this->__load();
        return parent::setPublicado($publicado);
    }

    public function getPublicado()
    {
        $this->__load();
        return parent::getPublicado();
    }

    public function setCodigoServicioOficial($codigo_servicio_oficial)
    {
        $this->__load();
        return parent::setCodigoServicioOficial($codigo_servicio_oficial);
    }

    public function getCodigoServicioOficial()
    {
        $this->__load();
        return parent::getCodigoServicioOficial();
    }

    public function setServicioOficial(\Entities\Servicio $servicioOficial = NULL)
    {
        $this->__load();
        return parent::setServicioOficial($servicioOficial);
    }

    public function getServicioOficial()
    {
        $this->__load();
        return parent::getServicioOficial();
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

    public function setEntidadCodigo($entidadCodigo)
    {
        $this->__load();
        return parent::setEntidadCodigo($entidadCodigo);
    }

    public function getEntidadCodigo()
    {
        $this->__load();
        return parent::getEntidadCodigo();
    }

    public function addUser(\Entities\User $user)
    {
        $this->__load();
        return parent::addUser($user);
    }

    public function getUser()
    {
        $this->__load();
        return parent::getUser();
    }

    public function addDataset(\Entities\Dataset $dataset)
    {
        $this->__load();
        return parent::addDataset($dataset);
    }

    public function getDataset()
    {
        $this->__load();
        return parent::getDataset();
    }

    public function setEntidad(\Entities\Entidad $entidad = NULL)
    {
        $this->__load();
        return parent::setEntidad($entidad);
    }

    public function getEntidad()
    {
        $this->__load();
        return parent::getEntidad();
    }

    public function getDatasetsMaestros()
    {
        $this->__load();
        return parent::getDatasetsMaestros();
    }

    public function esOficial()
    {
        $this->__load();
        return parent::esOficial();
    }

    public function validate()
    {
        $this->__load();
        return parent::validate();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'codigo', 'nombre', 'sigla', 'url', 'publicado', 'oficial', 'codigo_servicio_oficial', 'created_at', 'updated_at', 'entidad_codigo', 'servicioOficial', 'user', 'dataset', 'entidad');
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