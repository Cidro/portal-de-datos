<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 22-10-13
 * Time: 03:59 PM
 */

namespace Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * Servicio
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Servicio extends EntityRepository{

    private $errors = array();

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Obtiene un servicio por el nombre dado
     *
     * @param $nombre
     * @return Entities\Servicio
     */
    public function getServicioPorNombre($nombre){
        $qb = $this->_em->createQueryBuilder();

        $query = $qb->select('s')
                ->from('Entities\Servicio', 's')
                ->where('s.nombre = :nombre')
                ->setParameter('nombre', $nombre)
                ->getQuery();
        $servicio = $query->getOneOrNullResult();

        return $servicio;
    }

    /**
     * Obtiene una colección de servicios según las opciones entregadas
     *
     * @param array $options
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function findWithOptions(array $options){
        $qb = $this->_em->createQueryBuilder();
        $getTotal = isset($options['total']) && $options['total'];

        $select = $getTotal ? 'COUNT(s.codigo)' : 's AS servicio, COUNT(d.id) AS total_datasets';

        $qb->from('Entities\Servicio', 's')
            ->leftJoin('s.dataset', 'd', 'WITH', 'd.maestro = 1');

        if($options['nombre_servicio'])
            $qb->andWhere('s.nombre like :nombre_servicio')
                ->setParameter('nombre_servicio', '%'.$options['nombre_servicio'].'%');

        if($options['entidad_codigo'])
            $qb->andWhere('s.entidad_codigo = :entidad_codigo')
                ->setParameter('entidad_codigo', $options['entidad_codigo']);

        if(isset($options['con_recurso']) && $options['con_recurso']){
            $qb->leftJoin('d.recursos', 'r')
                ->andWhere('r.id IS NOT NULL');
        }

        if($getTotal){
            $result = $qb->select($select)->getQuery()->getSingleScalarResult();
        }else{
            $result = $qb->select($select)
                        ->orderBy($options['order_by'], $options['order_dir'])
                        ->setFirstResult($options['offset'])
                        ->setMaxResults($options['limit'])
                        ->groupBy('s.codigo')
                        ->getQuery()
                        ->getResult();
        }

        return $result;
    }


    /**
     * Crea un nuevo servicio
     *
     * @param array $attributes
     * @return \Entities\Servicio
     */
    public function creaServicio(array $atributos){
        $servicio = new \Entities\Servicio;

        $this->asignaAtributosServicio($servicio, $atributos);

        $servicio->setCreatedAt(new \DateTime());

        $this->setErrors($servicio->validate());

        if(!$this->getErrors()){
            $this->_em->persist($servicio);
            $this->_em->flush();
        }

        return $servicio;
    }

    /**
     * @param \Entities\Servicio $servicio
     * @param array $atributos
     * @return \Entities\Servicio
     */
    public function actualizaServicio(\Entities\Servicio $servicio, Array $atributos)
    {
        $this->asignaAtributosServicio($servicio, $atributos);

        $this->_em->persist($servicio);
        $this->_em->flush();

        return $servicio;
    }

    public function asignaAtributosServicio(\Entities\Servicio $servicio, Array $atributos){
        $CI = &get_instance();
        $CI->load->helper('array');

        $servicio_oficial = $this->_em->getRepository('Entities\Servicio')->findOneByCodigo(element('servicio_oficial', $atributos, ''));
        $entidad = $this->_em->getRepository('Entities\Entidad')->findOneByCodigo(element('entidad_codigo', $atributos, ''));

        $servicio->setCodigo(element('codigo', $atributos, null));
        $servicio->setEntidadCodigo(element('entidad_codigo', $atributos, ''));
        $servicio->setEntidad($entidad);
        $servicio->setNombre(element('nombre', $atributos, ''));
        $servicio->setSigla(element('sigla', $atributos, ''));
        $servicio->setUrl(element('url', $atributos, ''));
        $servicio->setUpdatedAt(new \DateTime());
        $servicio->setPublicado(element('publicado', $atributos, false));
        $servicio->setOficial(element('oficial', $atributos, false));
        $servicio->setServicioOficial($servicio_oficial);

        return $servicio;
    }


}