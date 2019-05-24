<?php
namespace AppBundle\Service;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Produit;
use AppBundle\Entity\PointVente; 
use Doctrine\Common\Collections\ArrayCollection;
class PrevisonalProduit
{
protected $_em;

public function __construct(EntityManager $_em)
{
$this->_em=$_em;
}


    public function getLignes(PointVente $pointVente,Produit $produit, $startDate=null, $endDate=null)
    {   
        return  $this->_em->getRepository('AppBundle:Ligne')->findLignes($pointVente,$produit, $startDate, $endDate);
    }




   public function dureeMoyenneEntreDeuxCommendes($lignes) //en jours
    {
        if (count($lignes)<2) {
            return -1;
        }
         $days=0;
         $count=0;
       for ($i=1; $i <count($lignes); $i++) { 
          if($lignes[$i]->getCommende()->getDate()==$lignes[$i-1]->getCommende()->getDate())
               continue;  
             $count++;        
            $interval=$lignes[$i]->getCommende()->getDate()->diff( $lignes[$i-1]->getCommende()->getDate());
            $days+=abs((int)$interval->format('%R%a'));
        } 
      return $count>0?ceil($days/$count):-1;;
    }



   public function quanteteMoyenneJour($lignes) //Can be quite small for some ones
    {
        if (count($lignes)<2) {
            return -1;
        }
        $totalMoyenne=0;
        $quantite=0;
        $count=0;
     for ($i=0; $i <count($lignes)-1 ; $i++) { 
          $quantite+=$lignes[$i]->getQuantite();        
         if($lignes[$i]->getCommende()->getDate()==$lignes[$i+1]->getCommende()->getDate())
               continue;  
            $interval=$lignes[$i]->getCommende()->getDate()->diff($lignes[$i+1]->getCommende()->getDate());
            $totalMoyenne+=$quantite/abs((int)$interval->format('%R%a'));
            $quantite=0;
            $count++;
           
        }
      return $count>0? ceil($totalMoyenne/$count):-1;
    }


       public function quanteteMoyenneCommende($lignes) //Can be quite small for some ones
    {
        if (count($lignes)<2) {
            return -1;
        }
        $quantite=0;
        $count=0;
     foreach ($lignes as $key => $ligne) {
            $quantite+=$ligne->getQuantite();
            if($key>0)
            if($lignes[$key-1]->getCommende()->getDate()==$lignes[$key]->getCommende()->getDate())
                continue;
            $count++;
            } 

      return $count>0? ceil($quantite/$count):-1;
    }

    
    public function lastLigne($lignes) //Can be quite small for some ones
    {
        if (count($lignes)<2) {
            return $lignes[count($lignes)-1];
        }
        $quantite=0;
       foreach ($lignes as $key => $ligne) {
            if($key>0)
            if($lignes[$key-1]->getCommende()->getDate()==$lignes[$key]->getCommende()->getDate()){
                 $quantite+=$ligne->getQuantite();
                continue;
            }
            else
              $quantite=$ligne->getQuantite();
              
            }         

      return (clone $lignes[count($lignes)-1])->setQuantite($quantite);
    }



       public function dateProchaineCommende(PointVente $pointVente,Produit $produit, $startDate=null, $endDate=null)
    {
        $previsions=[];
        $lignes=$this->getLignes($pointVente,$produit, $startDate, $endDate);
        $lastLigne=$this->lastLigne($lignes);
        $quantite=$lastLigne->getQuantite();
        $previsions['last_cmd_date']=$lastLigne->getCommende()->getDate()->format('Y-m-d');
        $previsions['last_cmd_quantity']=$quantite;
        $date=$lastLigne->getCommende()->getDate();
        if($quantite<$this->quanteteMoyenneJour($lignes))
            $nobreJourPrevisionnel=$this->dureeMoyenneEntreDeuxCommendes($lignes);
         else $nobreJourPrevisionnel=floor($quantite/$this->quanteteMoyenneJour( $lignes));
         if($nobreJourPrevisionnel<0)
            return   array('next_cmd_date' => null, );
          $date->modify('+'.$nobreJourPrevisionnel.' day');
      
       $previsions['next_cmd_date']=(clone $date);
       $previsions['next_cmd_quantity']=$this->quanteteMoyenneCommende( $lignes);
       $previsions['fq_of_cmd_']=$this->dureeMoyenneEntreDeuxCommendes( $lignes);
        return $previsions;
    }




    public function dureeEntreDeuxCommendes(PointVente $pointVente,Produit $produit, $startDate=null, $endDate=null)
    {   
        $lignes=$this->getCommendes($pointVente,$produit, $startDate, $endDate);
        return  dureeMoyenneEntreDeuxCommendes($lignes) ;
    }



    public function quantiteJour(PointVente $pointVente,Produit $produit, $startDate=null, $endDate=null)
    {   
        $lignes=$this->getCommendes($pointVente,$produit, $startDate, $endDate);
        return  quanteteMoyenneJour($lignes) ;
    }
}