<?php

namespace Proxies\__CG__\Entities;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Dataset extends \Entities\Dataset implements \Doctrine\ORM\Proxy\Proxy
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

    public function setTitulo($titulo)
    {
        $this->__load();
        return parent::setTitulo($titulo);
    }

    public function getTitulo()
    {
        $this->__load();
        return parent::getTitulo();
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

    public function setFrecuencia($frecuencia)
    {
        $this->__load();
        return parent::setFrecuencia($frecuencia);
    }

    public function getFrecuencia()
    {
        $this->__load();
        return parent::getFrecuencia();
    }

    public function setGranularidad($granularidad)
    {
        $this->__load();
        return parent::setGranularidad($granularidad);
    }

    public function getGranularidad()
    {
        $this->__load();
        return parent::getGranularidad();
    }

    public function setCoberturaTemporal($coberturaTemporal)
    {
        $this->__load();
        return parent::setCoberturaTemporal($coberturaTemporal);
    }

    public function getCoberturaTemporal()
    {
        $this->__load();
        return parent::getCoberturaTemporal();
    }

    public function setNdescargas($ndescargas)
    {
        $this->__load();
        return parent::setNdescargas($ndescargas);
    }

    public function getNdescargas()
    {
        $this->__load();
        return parent::getNdescargas();
    }

    public function setRating($rating)
    {
        $this->__load();
        return parent::setRating($rating);
    }

    public function getRating()
    {
        $this->__load();
        return parent::getRating();
    }

    public function setMaestro($maestro)
    {
        $this->__load();
        return parent::setMaestro($maestro);
    }

    public function getMaestro()
    {
        $this->__load();
        return parent::getMaestro();
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

    public function setPublicadoAt($publicadoAt)
    {
        $this->__load();
        return parent::setPublicadoAt($publicadoAt);
    }

    public function getPublicadoAt()
    {
        $this->__load();
        return parent::getPublicadoAt();
    }

    public function setHits($hits)
    {
        $this->__load();
        return parent::setHits($hits);
    }

    public function getHits()
    {
        $this->__load();
        return parent::getHits();
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

    public function setMaestroId($maestroId)
    {
        $this->__load();
        return parent::setMaestroId($maestroId);
    }

    public function getMaestroId()
    {
        $this->__load();
        return parent::getMaestroId();
    }

    public function setServicioCodigo($servicioCodigo)
    {
        $this->__load();
        return parent::setServicioCodigo($servicioCodigo);
    }

    public function getServicioCodigo()
    {
        $this->__load();
        return parent::getServicioCodigo();
    }

    public function setLicenciaId($licenciaId)
    {
        $this->__load();
        return parent::setLicenciaId($licenciaId);
    }

    public function getLicenciaId()
    {
        $this->__load();
        return parent::getLicenciaId();
    }

    public function setActualizable($actualizable)
    {
        $this->__load();
        return parent::setActualizable($actualizable);
    }

    public function getActualizable()
    {
        $this->__load();
        return parent::getActualizable();
    }

    public function setIntegracionJunar($integracion_junar)
    {
        $this->__load();
        return parent::setIntegracionJunar($integracion_junar);
    }

    public function getIntegracionJunar()
    {
        $this->__load();
        return parent::getIntegracionJunar();
    }

    public function setPrimeraVersionPublicada($primeraVersionPublicada)
    {
        $this->__load();
        return parent::setPrimeraVersionPublicada($primeraVersionPublicada);
    }

    public function getPrimeraVersionPublicada()
    {
        $this->__load();
        return parent::getPrimeraVersionPublicada();
    }

    public function addDataset(\Entities\Dataset $datasetVersion)
    {
        $this->__load();
        return parent::addDataset($datasetVersion);
    }

    public function getDatasetVersion()
    {
        $this->__load();
        return parent::getDatasetVersion();
    }

    public function addLog(\Entities\Log $logMaestro)
    {
        $this->__load();
        return parent::addLog($logMaestro);
    }

    public function getLogMaestro()
    {
        $this->__load();
        return parent::getLogMaestro();
    }

    public function getLogVersion()
    {
        $this->__load();
        return parent::getLogVersion();
    }

    public function addRecurso(\Entities\Recurso $recursos)
    {
        $this->__load();
        return parent::addRecurso($recursos);
    }

    public function getRecursos()
    {
        $this->__load();
        return parent::getRecursos();
    }

    public function addDocumento(\Entities\Documento $documentos)
    {
        $this->__load();
        return parent::addDocumento($documentos);
    }

    public function getDocumentos()
    {
        $this->__load();
        return parent::getDocumentos();
    }

    public function addEvaluacion(\Entities\Evaluacion $evaluaciones)
    {
        $this->__load();
        return parent::addEvaluacion($evaluaciones);
    }

    public function getEvaluaciones()
    {
        $this->__load();
        return parent::getEvaluaciones();
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

    public function setLicencia(\Entities\Licencia $licencia = NULL)
    {
        $this->__load();
        return parent::setLicencia($licencia);
    }

    public function getLicencia()
    {
        $this->__load();
        return parent::getLicencia();
    }

    public function setDatasetMaestro(\Entities\Dataset $datasetMaestro = NULL)
    {
        $this->__load();
        return parent::setDatasetMaestro($datasetMaestro);
    }

    public function getDatasetMaestro()
    {
        $this->__load();
        return parent::getDatasetMaestro();
    }

    public function addSector(\Entities\Sector $sectores)
    {
        $this->__load();
        return parent::addSector($sectores);
    }

    public function getSectores()
    {
        $this->__load();
        return parent::getSectores();
    }

    public function addTag(\Entities\Tag $tags)
    {
        $this->__load();
        return parent::addTag($tags);
    }

    public function getTags()
    {
        $this->__load();
        return parent::getTags();
    }

    public function addCategoria(\Entities\Categoria $categorias)
    {
        $this->__load();
        return parent::addCategoria($categorias);
    }

    public function getCategorias()
    {
        $this->__load();
        return parent::getCategorias();
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

    public function addVista(\Entities\Vista $vistas)
    {
        $this->__load();
        return parent::addVista($vistas);
    }

    public function getVistas()
    {
        $this->__load();
        return parent::getVistas();
    }

    public function setCoordenadas($coordenadas)
    {
        $this->__load();
        return parent::setCoordenadas($coordenadas);
    }

    public function getCoordenadas()
    {
        $this->__load();
        return parent::getCoordenadas();
    }

    public function setDocId($doc_id)
    {
        $this->__load();
        return parent::setDocId($doc_id);
    }

    public function getDocId()
    {
        $this->__load();
        return parent::getDocId();
    }

    public function validate()
    {
        $this->__load();
        return parent::validate();
    }

    public function compareWith(\Entities\Dataset $version)
    {
        $this->__load();
        return parent::compareWith($version);
    }

    public function getLastVersion()
    {
        $this->__load();
        return parent::getLastVersion();
    }

    public function hasCategoria(\Entities\Categoria $categoria_to_check)
    {
        $this->__load();
        return parent::hasCategoria($categoria_to_check);
    }

    public function updateCategorias($categorias)
    {
        $this->__load();
        return parent::updateCategorias($categorias);
    }

    public function updateTags($tags)
    {
        $this->__load();
        return parent::updateTags($tags);
    }

    public function updateSectores($sectores)
    {
        $this->__load();
        return parent::updateSectores($sectores);
    }

    public function updateRecursos($recursos)
    {
        $this->__load();
        return parent::updateRecursos($recursos);
    }

    public function updateDocumentos($documentos)
    {
        $this->__load();
        return parent::updateDocumentos($documentos);
    }

    public function generaVersion($checkChanges = true)
    {
        $this->__load();
        return parent::generaVersion($checkChanges);
    }

    public function createLog($cambios)
    {
        $this->__load();
        return parent::createLog($cambios);
    }

    public function togglePublicado()
    {
        $this->__load();
        return parent::togglePublicado();
    }

    public function logCambioPublicacion()
    {
        $this->__load();
        return parent::logCambioPublicacion();
    }

    public function formatosDisponibles()
    {
        $this->__load();
        return parent::formatosDisponibles();
    }

    public function checkUserAccess($rol = NULL)
    {
        $this->__load();
        return parent::checkUserAccess($rol);
    }

    public function getCantidadReportesPorEstados($estados = array (
  0 => 2,
  1 => 3,
  2 => 5,
))
    {
        $this->__load();
        return parent::getCantidadReportesPorEstados($estados);
    }

    public function getBtnReporteAsociadoCampo($campo = 'titulo', $claseExtra = '')
    {
        $this->__load();
        return parent::getBtnReporteAsociadoCampo($campo, $claseExtra);
    }

    public function getCategoriasString()
    {
        $this->__load();
        return parent::getCategoriasString();
    }

    public function getTagsString()
    {
        $this->__load();
        return parent::getTagsString();
    }

    public function getNombrePrimeraCategoria()
    {
        $this->__load();
        return parent::getNombrePrimeraCategoria();
    }

    public function toArray()
    {
        $this->__load();
        return parent::toArray();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'titulo', 'descripcion', 'frecuencia', 'granularidad', 'cobertura_temporal', 'ndescargas', 'rating', 'maestro', 'publicado', 'publicado_at', 'hits', 'created_at', 'updated_at', 'maestro_id', 'servicio_codigo', 'licencia_id', 'actualizable', 'primera_version_publicada', 'integracion_junar', 'coordenadas', 'doc_id', 'primeraVersionPublicada', 'datasetVersion', 'logMaestro', 'logVersion', 'recursos', 'documentos', 'evaluaciones', 'reportes', 'vistas', 'servicio', 'licencia', 'datasetMaestro', 'sectores', 'tags', 'categorias');
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