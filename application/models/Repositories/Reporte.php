<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * Reporte
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Reporte extends EntityRepository
{
    public function getReportesPendientesDataset($datasetId)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('COUNT(r.id)')
            ->from('Entities\Reporte', 'r')
            ->andWhere('r.estado IN (:ids)')
            ->setParameter('ids', array(2,3,5))
            ->andWhere('r.dataset = :datasetid')
            ->andWhere('r.updated_at IS NOT NULL')
            ->setParameter('datasetid', $datasetId);

        return intval($qb->getQuery()->getSingleScalarResult());
    }
    public function findWithOptions($options = array())
    {
        $qb = $this->_em->createQueryBuilder();

        if(isset($options['total'])){
            $qb->select('count(r.id) as total');
        }else{
            $qb->select('r, d');
        }

        $qb->from('Entities\Reporte', 'r')
            ->leftJoin('r.dataset', 'd')
            ->leftJoin('r.tipoReporte', 't')
            ->leftJoin('t.gradoReporte', 'g');

        if(isset($options['dataset_id'])){
            $qb->andWhere('r.estado <> 1') //Solo se aceptan los que se hayan revisado internamente
                ->andWhere('r.dataset = :datasetid')
                ->setParameter('datasetid', intval($options['dataset_id']));
        }

        if($options['estado']){
            $qb->andWhere('r.estado = '.intval($options['estado']));
        }

        if($options['tipo_reporte_id']){
            $qb->andWhere('r.tipoReporte = '.intval($options['tipo_reporte_id']));
        }

        if($options['codigo_servicio']){
            $qb->andWhere('d.servicio = :codigo_servicio')
                ->setParameter(':codigo_servicio', $options['codigo_servicio']);
        }

        if(!$options['muestra_despublicados']){
            $qb->andWhere('d.publicado = 1');
        }

        if(isset($options['total'])){
            return $qb->getQuery()->getSingleScalarResult();
        }else{
            if(!$options['excel']){
                $qb->setFirstResult($options['offset'])
                    ->setMaxResults($options['limit']);
            }
            return $qb->orderBy($options['orderby'], $options['orderdir'])
                        ->getQuery()
                        ->getResult();
        }
    }
}