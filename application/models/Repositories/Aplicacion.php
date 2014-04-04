<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * Aplicacion
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Aplicacion extends EntityRepository{
	//Busca las aplicaciones con el orden y los filtros dados
	public function findWithOrdering($options = null, $ordering = array('created_at' => 'DESC'), $limit = 4, $offset = 0){
		$qb = $this->_em->createQueryBuilder();

		$qb->from('Entities\Aplicacion', 'a');

		if(isset($options['total'])){
			$qb->select('COUNT(a.id)');
		}else{
			$qb->select('a');
			foreach ($ordering as $field => $dir) {
				$qb->addOrderBy('a.'.$field, $dir);
			}
		}
		
		if(!isset($options['all']))
			$qb->where('a.publicado = 1');

		//Filtros de busqueda
		if($options){
			//Como es el único filtro para las aplicaciones, se usa este nombre genérico
			if(isset($options['filterby'])){
				$qb->andWhere('a.acceso = :acceso');
				$qb->setParameter('acceso', $options['filterby']);
			}
		}

		if(isset($options['total'])){
			return $qb->getQuery()->getSingleScalarResult();
		}else{
			$query = $qb->setFirstResult($offset)
									->setMaxResults($limit)
									->getQuery();
			return $query->getResult();
		}
	}
}