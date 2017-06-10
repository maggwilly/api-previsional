<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProgrammeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProgrammeRepository extends EntityRepository
{

  /**
  *Nombre de synchro effectue par utilisateur 
  */
  public function findDispo(){
         $qb = $this->createQueryBuilder('p')->join('p.matieres','m'); 
          return $qb->getQuery()->getResult();
  }

}
