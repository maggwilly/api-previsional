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


    public function getLignes(PointVente $pointVente,Produit $produit,  $endDate=null)
    {   
        return  $this->_em->getRepository('AppBundle:Ligne')->findLignes($pointVente,$produit,  $endDate);
    }




   public function dureeMoyenneEntreDeuxCommendes($lignes) //en jours
    {   
        if (count($lignes)<2) {
            return -1;
        }
        $int=[];
         $days=0;
         $count=0;
       for ($i=1; $i <count($lignes); $i++) {
          if($lignes[$i]->getCommende()->getDate()==$lignes[$i-1]->getCommende()->getDate())
               continue; 
             $int[]=$lignes[$i]->getCommende()->getDate();    
              $int[]=$lignes[$i-1]->getCommende()->getDate();    
            $interval=$lignes[$i]->getCommende()->getDate()->diff($lignes[$i-1]->getCommende()->getDate());
            $days+=abs((int)$interval->format('%R%a'));
            $count++; 
        } 
        if($count<2)
            return -1;  
      return  ceil($days/$count);
    }



   public function quanteteMoyenne($lignes) //Can be quite small for some ones
    {
          $qte=[];
        if (count($lignes)<2) {
            return $qte;
        }
        $totalMoyenne=0;
        $quantite=0;
        $count=0;
    for ($i=0; $i <count($lignes)-1 ; $i++) { 
          $quantite+=$lignes[$i]->getQuantite();        
         if($lignes[$i]->getCommende()->getDate()==$lignes[$i+1]->getCommende()->getDate())
               continue;  
            $interval=$lignes[$i]->getCommende()->getDate()->diff($lignes[$i+1]->getCommende()->getDate());
            if(abs((int)$interval->format('%R%a'))>0){
               $totalMoyenne+=$quantite/abs((int)$interval->format('%R%a'));
               $count++; 
            }
            $quantite=0; 
          }
        if($count<2||$totalMoyenne==0)
            return $qte;
           $quantite=$totalMoyenne/$count;
           $qte=['quantite'=>$quantite,'target'=>1];
           while ($quantite<1) {
             $qte['target']++;
             $quantite*=$qte['target'];
           }
           $qte['quantite']=ceil($quantite);
           if($qte['quantite']%$qte['target']==0){
              $qte['quantite']=$qte['quantite']/$qte['target'];
              $qte['target']=1;
           }
             
      return $qte;
    }


    
    public function lastLigne($lignes) //Can be quite small for some ones
    {
        if (count($lignes)==1) {
               return $lignes[0];
        }elseif (empty($lignes)) {
            return null;
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



       public function findPrevisions(PointVente $pointVente,Produit $produit, $endDate=null)
    {
          $previsions=[];
          $previsions['id']=$produit->getId();
          $previsions['nom']=$produit->getNom();
          $previsions['description']=$produit->getDescription();
          $previsions['next_cmd_date']=null;
          $lignes=$this->getLignes($pointVente,$produit,  $endDate);
          $lastLigne=$this->lastLigne($lignes);
        if(is_null($lastLigne)){
          return $previsions;
        }
        $quantite=$lastLigne->getQuantite();
        $previsions['last_cmd_date']=$lastLigne->getCommende()->getDate();
        $previsions['last_cmd_quantity']=$quantite;
         if(empty($this->quanteteMoyenne($lignes)))
           return $previsions;
        if($quantite<=$this->quanteteMoyenne($lignes)['quantite']){
            $nobreJourPrevisionnel=min($this->dureeMoyenneEntreDeuxCommendes($lignes),$this->quanteteMoyenne($lignes)['target']);
          }
         else
          $nobreJourPrevisionnel=ceil(($quantite/$this->quanteteMoyenne($lignes)['quantite'])*$this->quanteteMoyenne($lignes)['target']);
       $date=clone $lastLigne->getCommende()->getDate();
       $date->modify('+'.$nobreJourPrevisionnel.' day');
       $previsions['next_cmd_date']=(clone $date);
       $previsions['target']= $this->quanteteMoyenne($lignes);
       $previsions['next_cmd_quantity']=$this->quanteteMoyenneCommende($lignes);
       $previsions['next_cmd_cost']=$this->quanteteMoyenneCommende($lignes)*$produit->getCout();
       $previsions['fq_of_cmd']=$this->dureeMoyenneEntreDeuxCommendes($lignes);
        return $previsions;
    }




    public function dureeEntreDeuxCommendes(PointVente $pointVente,Produit $produit, $endDate=null)
    {   
        $lignes=$this->getCommendes($pointVente,$produit, $endDate);
        return  dureeMoyenneEntreDeuxCommendes($lignes) ;
    }



    public function quantiteJour(PointVente $pointVente,Produit $produit,  $endDate=null)
    {   
        $lignes=$this->getCommendes($pointVente,$produit,  $endDate);
        return  quanteteMoyenne($lignes) ;
    }
}