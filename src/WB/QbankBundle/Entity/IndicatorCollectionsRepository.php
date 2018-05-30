<?php

namespace WB\QbankBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * IndicatorCollectionsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IndicatorCollectionsRepository extends EntityRepository
{
    public function countIndicatorCollections()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(g.id)
                FROM WBQbankBundle:IndicatorCollections g'
            );

        return $query->getSingleScalarResult();
    }

    public function searchIndicatorCollections($keyword)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT i
                FROM WBQbankBundle:IndicatorCollections i
                WHERE i.name LIKE :keyword
                OR i.description LIKE :keyword
                ORDER BY i.name ASC'
            )->setParameter('keyword', '%' . $keyword . '%');

        return $query->getResult();
    }

}