<?php

namespace WB\QbankBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TermGroupsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TermGroupsRepository extends EntityRepository
{
    public function countTermGroups()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(g.id)
                FROM WBQbankBundle:TermGroups g'
            );

        return $query->getSingleScalarResult();
    }

}