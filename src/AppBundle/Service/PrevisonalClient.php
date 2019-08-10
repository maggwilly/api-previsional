<?php
namespace AppBundle\Service;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Rendezvous;
use AppBundle\Entity\PointVente; 
use AppBundle\Entity\User; 



class PrevisonalClient
{
    protected $_provisionalProduit;
    protected $_em;


public function __construct(EntityManager $_em,PrevisonalProduit $_provisionalProduit)
  {
     $this->_provisionalProduit=$_provisionalProduit;
     $this->_em=$_em;
    }

    public function getCommendes(User $user=null,PointVente $pointVente=null,$alls=[""])
    {   
        return  $this->_em->getRepository('AppBundle:Commende')->findCommendes($user,$pointVente,$alls);
    }


    public function getRendezvouss(PointVente $pointVente=null,$alls=null)
    {   
        return  $this->_em->getRepository('AppBundle:Rendezvous')->findRendezvouss($pointVente,$alls);
    }


    public function findLastCommende(PointVente $pointVente=null, $endDate=null,$alls=[""])
    {   
        return  $this->_em->getRepository('AppBundle:Commende')->findLast($pointVente,$endDate,$alls);
    }



    public function findLastRendevous(PointVente $pointVente=null,$alls=[""])
    {   
        return  $this->_em->getRepository('AppBundle:Rendezvous')->findLast($pointVente,$alls);
    }


    public function findFirstCommende(PointVente $pointVente=null, $endDate=null)
    {   
        return  $this->_em->getRepository('AppBundle:Commende')->findFirst($pointVente,$endDate);
    }



    public function findNextRendevous(PointVente $pointVente=null,$endDate=null)
    {

      if($pointVente==null)
         return ;
        $lastCommende=$this->findLastCommende($pointVente);
        $rendezvous= $this->findLastRendevous($pointVente,$endDate);   
        $produits=$this->_em->getRepository('AppBundle:Produit')->findByUser($pointVente->getUser()->getParent());
        foreach ($produits as $produit) {
        $previsions= $this->_provisionalProduit->findPrevisions($pointVente,$produit,$endDate);
         if((is_null($rendezvous)
          ||($lastCommende!=null&&$lastCommende->getDate()>=$rendezvous->getDateat()))
          ||!$rendezvous->getPersist()&&!is_null($previsions['next_cmd_date'])&&($previsions['next_cmd_date']<$rendezvous->getDateat()
          ||!$rendezvous->getDateat())){

          if((is_null($rendezvous)
            ||($lastCommende!=null&&$lastCommende->getDate()>=$rendezvous->getDateat()))){
               $rendezvous=new Rendezvous($previsions['next_cmd_date'],$pointVente,null,false);
               }
              if(!$rendezvous->getPersist()&&!is_null($previsions['next_cmd_date'])&&($previsions['next_cmd_date']<$rendezvous->getDateat()
                ||!$rendezvous->getDateat())) 
                  
                  $rendezvous->setDateat($previsions['next_cmd_date']); 
             }  
              $rendezvous->addPrevisions($previsions);
           }
           if($rendezvous&&$rendezvous->getDateat()!=null&&!$rendezvous->getStored()){
                $rendezvous->setStored(true);
               $this->_em->persist($rendezvous);
            } 
             $this->_em->flush();       
        return $rendezvous;
    }




    public function addPrevisions(Rendezvous $rendezvous=null,$canCreateNew=true)
    {
       if($rendezvous==null)
         return ;
          $pointVente=$rendezvous->getPointVente();
      if($canCreateNew)
        return $this->findNextRendevous($pointVente,$endDate);
       $produits=$this->_em->getRepository('AppBundle:Produit')->findByUser($pointVente->getUser()->getParent());
        foreach ($produits as $produit) {
         $previsions= $this->_provisionalProduit->findPrevisions($pointVente,$produit);
         $rendezvous->addPrevisions($previsions);
      }
        return $rendezvous;
    }


    public function getPrevisions(Rendezvous $rendezvous=null)
    {
       $lprevisions=[];
       if($rendezvous==null)
         return [] ;
       $pointVente=$rendezvous->getPointVente();
       $produits=$this->_em->getRepository('AppBundle:Produit')->findByUser($pointVente->getUser()->getParent());
      foreach ($produits as $produit) {
         $previsions[]= $this->_provisionalProduit->findPrevisions($pointVente,$produit,$rendezvous->getDateat());
      }
        return $previsions;
    }

}