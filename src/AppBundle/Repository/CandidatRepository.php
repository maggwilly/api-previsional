<?php

namespace AppBundle\Repository;

/**
 * CandidatRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CandidatRepository extends \Doctrine\ORM\EntityRepository
{

 /**
  *Nombre de synchro effectue par utilisateur 
  */
  public function findOneOrNull($studentId){
         $qb = $this->createQueryBuilder('a')
         ->where('a.studentId=:studentId')->setParameter('studentId',$studentId);
          return $qb->getQuery()->getOneOrNullResult();
  }
}