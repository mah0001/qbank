<?php

namespace WB\QbankBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * QuestionnaireGroupRelModulesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionnaireGroupRelModulesRepository extends EntityRepository
{
    public function getQuestionnairesReferences($published, $keyword, $excludedIds)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder();
        $query
            ->select('r')
            ->from('WBQbankBundle:QuestionnaireGroupRelModules', 'r')
            ->join('r.questModuleId', 'q')
            ->orderBy('r.weight', 'ASC');

        if ($keyword) {
            $query
                ->leftJoin('q.questionnaireModuleQuestions', 'qq')
                ->where(
                    $query->expr()->orX(
                        $query->expr()->like('q.name', ':keyword'),
                        $query->expr()->like('q.description', ':keyword'),
                        $query->expr()->like('qq.description', ':keyword'),
                        $query->expr()->like('qq.literalText', ':keyword')
                    )
                )
                ->setParameter('keyword', "%" . $keyword . "%");
        }

        if ($published) {
            $query
                ->andWhere("q.published = 1");
        }

        if (!empty($excludedIds)) {
            $query
                ->andWhere($query->expr()->notIn('q.id', ':excludedIds'))
                ->setParameter('excludedIds', $excludedIds);
        }


        $q = $query->getQuery();
        return $q->getResult();
    }

}