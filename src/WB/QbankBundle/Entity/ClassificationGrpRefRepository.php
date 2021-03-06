<?php

namespace WB\QbankBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ClassificationGrpRefRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClassificationGrpRefRepository extends EntityRepository
{
    public function getClassificationsReferences($published, $keyword, $excludedIds = array())
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder();
        $query
            ->select('r')
            ->from('WBQbankBundle:ClassificationGrpRef', 'r')
            ->join('r.classificationId', 'c')
            ->orderBy('r.weight', 'ASC');

        if ($keyword) {
            $query
                ->leftJoin('c.classificationCodes', 'cc')
                ->where(
                    $query->expr()->orX(
                        $query->expr()->like('c.name', ':keyword'),
                        $query->expr()->like('c.description', ':keyword'),
                        $query->expr()->like('cc.label', ':keyword')
/*                        $query->expr()->like('cc.description', ':keyword'),
                        $query->expr()->like('cc.value', ':keyword')*/
                    )
                )
                ->setParameter('keyword', "%" . $keyword . "%");
        }

        if ($published) {
            $query
                ->andWhere("c.published = 1");
        }

        if (!empty($excludedIds)) {
            $query
                ->andWhere($query->expr()->notIn('c.id', ':excludedIds'))
                ->setParameter('excludedIds', $excludedIds);
        }


        $q = $query->getQuery();
        return $q->getResult();
    }

}
