<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * TipoReporte
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TipoReporte extends EntityRepository
{
    public function findPublicos()
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('t')
            ->from('Entities\TipoReporte', 't')
            ->where('t.publico = 1');

        return $qb->getQuery()->getResult();
    }
}