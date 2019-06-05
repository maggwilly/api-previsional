<?php
namespace AppBundle\Service;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Rendezvous;
use AppBundle\Entity\PointVente; 
class PrevisonalClient
{
protected $_provisionalProduit;
protected $_em;
public function __construct(EntityManager $_em,PrevisonalProduit $_provisionalProduit)
{
$this->_provisionalProduit=$_provisionalProduit;
$this->_em=$_em;
}

    public function getCommendes(PointVente $pointVente, $startDate=null, $endDate=null)
    {   
        return  $this->_em->getRepository('AppBundle:Commende')->findCommendes(null,$pointVente, $startDate, $endDate);
    }



    public function dateProchaineCommende(PointVente $pointVente, $startDate=null, $endDate=null)
    {
           $rendezvous=$pointVente->getRendezvous()==null?new Rendezvous(null,$pointVente,null):$pointVente->getRendezvous();
        $produits=$this->_em->getRepository('AppBundle:Produit')->findByUser($pointVente->getUser()->getParent());
        foreach ($produits as $produit) {
        $previsions= $this->_provisionalProduit->dateProchaineCommende($pointVente,$produit, $startDate, $endDate);
         if (is_null($rendezvous->getId())&&($previsions['next_cmd_date']<$rendezvous->getDateat()||$rendezvous->getDateat()==null)){
              $rendezvous->setDateat($previsions['next_cmd_date'])
               ->addPrevisions($previsions);
          }
        }
        return $rendezvous;
    }

}