<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * Entidad
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Entidad extends EntityRepository{

	/*Obtiene un listado de las entidades que tienen algún dataset asociado*/
	/*La colección devuelta contiene también los servicios y los datasets*/
	public function findWithDataset(){

		$qb = $this->_em->createQueryBuilder();
		
		$result = $qb->select(array('e','s','d'))
			->from('Entities\Entidad', 'e')
			->leftJoin('e.servicio', 's')
			->leftJoin('s.dataset', 'd')
			->where('d.publicado = 1 and d.maestro = 0')
            ->andWhere('s.publicado = 1')
			->getQuery()
			->getResult();

		return $result;
	}
	public function findEntidad(){
		$qb= $this->_em->createQueryBuilder();

		$result = $qb->select('e')
					 ->from('Entities\Entidad','e')
					 ->getQuery()
					 ->getResult();

		return $result;
	}

    public function getEntidadesConTotales($limit = null)
    {
        $sql = "SELECT e, count(d.id) as ndatasets FROM Entities\Entidad e"
            . " LEFT JOIN e.servicio s"
            . " LEFT JOIN s.dataset d"
            . " WHERE d.publicado = 1 AND d.maestro = 0"
            . " GROUP BY e.codigo"
            . " ORDER BY ndatasets DESC";
        $query = $this->_em->createQuery($sql);
        
        if($limit)
            $query->setMaxResults($limit);

        return $query->getResult();
    }
}