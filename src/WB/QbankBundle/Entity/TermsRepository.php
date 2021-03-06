<?php

namespace WB\QbankBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TermsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TermsRepository extends EntityRepository
{
    public function countTerms()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(t.id)
                FROM WBQbankBundle:Terms t'
            );

        return $query->getSingleScalarResult();
    }

    public function searchTerms($classified, $published, $keyword, $excludedIds, $sort = 'ASC')
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder();
        $query
            ->select('t')
            ->from('WBQbankBundle:Terms', 't')
            ->orderBy('t.name', $sort);

        if ($keyword) {
            $query
                ->where(
                    $query->expr()->orX(
                        $query->expr()->like('t.name', ':keyword'),
                        $query->expr()->like('t.description', ':keyword')
                    )
                )
                ->setParameter('keyword', "%" . $keyword . "%");
        }

        if (false !== $classified) {
            $query
                ->leftJoin('t.termGrpRef', 'g')
                ->andWhere("g.id IS " . $classified);
        }

        if (false !== $published) {
            $query
                ->andWhere("t.published = :published")
                ->setParameter('published', $published);
        }

        if (!empty($excludedIds)) {
            $query
                ->andWhere($query->expr()->notIn('t.id', ':excludedIds'))
                ->setParameter('excludedIds', $excludedIds);
        }


        $q = $query->getQuery();
        return $q->getResult();
    }


}
