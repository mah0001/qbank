<?php

namespace WB\QbankBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * ClassificationCodesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClassificationCodesRepository extends EntityRepository
{

    public static function getClassificationCodesDTO(EntityManager $em, $id)
    {

        $query = $em->createQuery('SELECT NEW \WB\QbankBundle\DTO\ClassificationCodeDTO(c.id,c.label,c.value) FROM WBQbankBundle:ClassificationCodes c WHERE c.id =' . $id);
        $classificationCode = $query->getResult();
        return $classificationCode[0];
    }

    public static function getClassificationCodesDTOByClassification(EntityManager $em, $classsificationId, $questionId)
    {
        //$query = $em->createQuery('SELECT NEW \WB\QbankBundle\DTO\ClassificationCodeDTO(c.id,c.label,c.value,null,null,c.classification_id) FROM WBQbankBundle:ClassificationCodes c WHERE c.classification_id =' . $id);
        $query = $em->createQuery('SELECT NEW \WB\QbankBundle\DTO\ClassificationCodeDTO(c.id,c.label,c.value,q.questionId,q.skipValue) FROM WBQbankBundle:ClassificationCodes c, WBQbankBundle:QuestionsRelClassifications q  JOIN
                c.questionsRelClassifications WHERE c.classificationId =' . $classsificationId . ' AND (q.questionId  = ' .
                $questionId . 'OR q.questionId is NULL )');
        $classificationCodes = $query->getResult();
        return $classificationCodes;
    }
}
