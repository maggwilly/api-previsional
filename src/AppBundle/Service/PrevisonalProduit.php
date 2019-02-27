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


    public function getCommendes(PointVente $pointVente,Produit $produit, $startDate=null, $endDate=null)
    {   
        return  $this->_em->getRepository('AppBundle:Ligne')->findCommendes($pointVente,$produit, $startDate, $endDate);
    }


    public function getLastCommende(PointVente $pointVente,Produit $produit, $startDate=null, $endDate=null)
    {
        $lignes=$this->getCommendes($pointVente,$produit, $startDate, $endDate);
        return $lignes->last();
    }


   public function dureeMoyenneEntreDeuxCommendes($lignes) //en jours
    {
        if (count($lignes)<2) {
            return -1;
        }
        $days=0;
       for ($i=1; $i < count($lignes)-1; $i++) { 
           $days+=date_diff($lignes[$i]->getCommende()->getDate(), $lignes[$i-1]->getCommende()->getDate());
        } 
      return ceil($days/(count($lignes)-1));
    }



   public function quanteteMoyenneJour($lignes) //peut-être très petit pour certains produits
    {
        if (count($lignes)<2) {
            return -1;
        }

        $totalMoyenne=0;
        for ($i=1; $i <count($lignes)-1 ; $i++) { 
            $totalMoyenne+=$lignes[$i-1]->getQuantite()/(date_diff($lignes[$i]->getCommende()->getDate(), $lignes[$i-1]->getCommende()->getDate()));
        }
   
      return ($totalMoyenne/(count($lignes)-1)),2);
    }


       public function dateProchaineCommende(PointVente $pointVente,Produit $produit, $startDate=null, $endDate=null)
    {
        $lignes=$this->getCommendes($pointVente,$produit, $startDate, $endDate);
        if (count($lignes)<2) 
            return null;
        $lastCommende=$lignes->last();
        $quantite=$lastCommende->getQuantite();
        $date=$lastCommende->getCommende()->getDate();
        $nobreJourPrevisionnel=floor($quantite/$this->quanteteMoyenneJour($lignes));
        if($nobreJourPrevisionnel>$this->dureeMoyenneEntreDeuxCommendes($lignes))
            $nobreJourPrevisionnel=$this->dureeMoyenneEntreDeuxCommendes($lignes);
        $date->modify('+'.$nobreJourPrevisionnel.' day');
        return $date;
    }


public function nombreJourAvantProchaineCommende(PointVente $pointVente,Produit $produit, $startDate=null, $endDate=null)
    {
        $lignes=$this->getCommendes($pointVente,$produit, $startDate, $endDate);
        if (count($lignes)<2) 
            return -1;
        $lastCommende=$lignes->last();
        $quantite=$lastCommende->getQuantite();
        $date=$lastCommende->getCommende()->getDate();
        $nobreJourPrevisionnel=floor($quantite/$this->quanteteMoyenneJour($lignes));
        if($nobreJourPrevisionnel>$this->dureeMoyenneEntreDeuxCommendes($lignes))
            $nobreJourPrevisionnel=$this->dureeMoyenneEntreDeuxCommendes($lignes);
        return $nobreJourPrevisionnel;
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