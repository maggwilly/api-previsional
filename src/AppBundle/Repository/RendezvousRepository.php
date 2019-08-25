<?php

namespace AppBundle\Repository;
use AppBundle\Entity\PointVente; 
use AppBundle\Entity\User; 
/**
 * RendezvousRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RendezvousRepository extends \Doctrine\ORM\EntityRepository
{

      public function findRendezvouss(PointVente $pointVente=null,$alls=[""],$keys=[""]){
        $qb = $this->createQueryBuilder('r');
        
          if($pointVente!=null){
            $qb->andWhere('r.pointVente=:pointVente')
             ->setParameter('pointVente', $pointVente);
            } 
          if($alls&&array_key_exists('doneBy',$alls)&&$alls['doneBy']){
             $user= $this->_em->getRepository('AppBundle:User')->find($alls['doneBy']);
              $qb->andWhere('r.user=:doneBy')->setParameter('doneBy', $user);
            }  
         if($alls&&array_key_exists('afterdate',$alls)){
             $qb->andWhere('r.dateat>=:afterdate')
             ->setParameter('afterdate',new \DateTime($alls['afterdate']));
            }
         if($alls&&array_key_exists('beforedate',$alls)){
             $qb->andWhere('r.dateat<=:beforedate')
             ->setParameter('beforedate',new \DateTime($alls['beforedate']));
            }                      
          $qb->andWhere($qb->expr()->notIn('r.id', $keys));     
          return $qb->getQuery()->getResult(); 
  }

      /*Dernier commende dans un point de vente*/

   public function findLast(PointVente $pointVente,$alls=[""]){
           $qb = $this->createQueryBuilder('c'); 
          if($pointVente!=null){
            $qb->andWhere('c.pointVente=:pointVente')
             ->setParameter('pointVente', $pointVente);
            }
         if($alls&&array_key_exists('afterdate',$alls)){
             $qb->andWhere('c.date>=:afterdate')
             ->setParameter('afterdate',new \DateTime($alls['afterdate']));
            }
         if($alls&&array_key_exists('beforedate',$alls)){
             $qb->andWhere('c.date<=:beforedate')
             ->setParameter('beforedate',new \DateTime($alls['beforedate']));
            }           
            $qb->orderBy('c.date','desc');
            return $qb->getQuery()->setMaxResults(1)->getOneOrNullresult();  
      }

}
