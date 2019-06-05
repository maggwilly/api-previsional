<?php

namespace AppBundle\Repository;
use Doctrine\ORM\NoResultException;
use AppBundle\Entity\Produit; 
use AppBundle\Entity\PointVente; 
/**
 * LigneRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LigneRepository extends \Doctrine\ORM\EntityRepository
{

      public function findLignes(PointVente $pointVente=null,Produit $produit=null, $startDate=null, $endDate=null,$order='asc',$limit=null){
           $qb = $this->createQueryBuilder('l')->join('l.commende','c');
           if($pointVente)
           $qb->where('c.pointVente=:pointVente')->setParameter('pointVente', $pointVente);
          if($produit)
          $qb->andWhere('l.produit=:produit')->setParameter('produit', $produit);
            if($startDate!=null){
           $qb->andWhere('c.date>=:startDate')
          ->setParameter('startDate', new \DateTime($startDate));
          }
          if($endDate!=null){
           $qb->andWhere('c.date<=:endDate')
          ->setParameter('endDate',new \DateTime($endDate));
          }
          $qb->orderBy('c.date', $order);
          if($limit)
            return $qb->getQuery()->setFirstResult(0)->setMaxResults($limit)->getResult();
         return $qb->getQuery()->getResult();  
  }
}
