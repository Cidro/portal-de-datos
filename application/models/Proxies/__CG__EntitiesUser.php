<?php

namespace Proxies\__CG__\Entities;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class User extends \Entities\User implements \Doctrine\ORM\Proxy\Proxy
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

    public function setPassword($password)
    {
        $this->__load();
        return parent::setPassword($password);
    }

    public function getPassword()
    {
        $this->__load();
        return parent::getPassword();
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

    public function setFullname($fullname)
    {
        $this->__load();
        return parent::setFullname($fullname);
    }

    public function getFullname()
    {
        $this->__load();
        return parent::getFullname();
    }

    public function setMinisterial($ministerial)
    {
        $this->__load();
        return parent::setMinisterial($ministerial);
    }

    public function getMinisterial()
    {
        $this->__load();
        return parent::getMinisterial();
    }

    public function setInterministerial($interministerial)
    {
        $this->__load();
        return parent::setInterministerial($interministerial);
    }

    public function getInterministerial()
    {
        $this->__load();
        return parent::getInterministerial();
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

    public function setResetCode($resetCode)
    {
        $this->__load();
        return parent::setResetCode($resetCode);
    }

    public function getResetCode()
    {
        $this->__load();
        return parent::getResetCode();
    }

    public function setResetExpiration($resetExpiration)
    {
        $this->__load();
        return parent::setResetExpiration($resetExpiration);
    }

    public function getResetExpiration()
    {
        $this->__load();
        return parent::getResetExpiration();
    }

    public function setApiToken($apiToken)
    {
        $this->__load();
        return parent::setApiToken($apiToken);
    }

    public function getApiToken()
    {
        $this->__load();
        return parent::getApiToken();
    }

    public function addDataset(\Entities\Dataset $logDataset)
    {
        $this->__load();
        return parent::addDataset($logDataset);
    }

    public function getLogDataset()
    {
        $this->__load();
        return parent::getLogDataset();
    }

    public function setServicio(\Entities\Servicio $servicio = NULL)
    {
        $this->__load();
        return parent::setServicio($servicio);
    }

    public function getServicio()
    {
        $this->__load();
        return parent::getServicio();
    }

    public function addRol(\Entities\Rol $rols)
    {
        $this->__load();
        return parent::addRol($rols);
    }

    public function getRols()
    {
        $this->__load();
        return parent::getRols();
    }

    public function addReporte(\Entities\Reporte $reportes)
    {
        $this->__load();
        return parent::addReporte($reportes);
    }

    public function getReportes()
    {
        $this->__load();
        return parent::getReportes();
    }

    public function hasRol($id_rols)
    {
        $this->__load();
        return parent::hasRol($id_rols);
    }

    public function removeAllRols()
    {
        $this->__load();
        return parent::removeAllRols();
    }

    public function getHashedPassword($password)
    {
        $this->__load();
        return parent::getHashedPassword($password);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'password', 'email', 'fullname', 'ministerial', 'interministerial', 'reset_code', 'reset_expiration', 'api_token', 'created_at', 'updated_at', 'logDataset', 'reportes', 'servicio', 'rols');
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