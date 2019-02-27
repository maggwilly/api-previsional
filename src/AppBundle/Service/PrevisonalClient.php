<?php
namespace AppBundle\Service;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Produit;
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
        return  $this->_em->getRepository('AppBundle:PointVente')->findCommendes($pointVente,null, $startDate, $endDate);
    }


   public function dureeMoyenneEntreDeuxCommendes($commendes) //en jours
    {
        if (count($commendes)<2) {
            return -1;
        }
        $days=0;
       for ($i=1; $i < count($commendes)-1; $i++) { 
           $days+=date_diff($commendes[$i]->getDate(), $commendes[$i-1]->getDate());
        } 
      return ceil($days/(count($commendes)-1));
    }


        
    public function dureeEntreDeuxCommendes(PointVente $pointVente, $startDate=null, $endDate=null)
    {   
        $commendes=$this->getCommendes($pointVente, $startDate, $endDate);
        return  dureeMoyenneEntreDeuxCommendes($commendes) ;
    }

  

    

    public function dateProchaineCommende(PointVente $pointVente, $startDate=null, $endDate=null)
    {
        $commendes=$this->getCommendes($pointVente, $startDate, $endDate);
        if (count($lignes)<2) 
            return null;
        $lastCommende=$commendes->last();
        $date=$lastCommende->getCommende()->getDate();
        $nobreJourPrevisionnel=$this->dureeMoyenneEntreDeuxCommendes($commendes);
        $date->modify('+'.$nobreJourPrevisionnel.' day');
        $produits=$pointVente->getUser()->getProduits();
        $nextCmdDate=$date;
        foreach ($produits as $produit) {
          $produitNextCmdDate= $this->_provisionalProduit->dateProchaineCommende($pointVente,$produit, $startDate, $endDate);
          if (!is_null($produitNextCmdDate)&&$produitNextDate<$nextCmdDate) {
               $nextCmdDate=$produitNextCmdDate;
          }
        }
        return $nextCmdDate;
    }


    
    public function nombreJourAvantProchaineCommende(PointVente $pointVente, $startDate=null, $endDate=null)
    {
        $commendes=$this->getCommendes($pointVente, $startDate, $endDate);
        if (count($commendes)<2) 
            return -1;
        $lastCommende=$commendes->last();
        $date=$lastCommende->getCommende()->getDate();
        $nobreJourPrevisionnel=$this->dureeMoyenneEntreDeuxCommendes($commendes);
        $produits=$pointVente->getUser()->getProduits();
        $nextCmdDate=$nobreJourPrevisionnel;
        foreach ($produits as $produit) {
          $produitNextCmdDate= $this->_provisionalProduit->nombreJourAvantProchaineCommende($pointVente,$produit, $startDate, $endDate);
          if (($produitNextCmdDate>0)&&($produitNextCmdDate<$nextCmdDate)) {
               $nextCmdDate=$produitNextCmdDate;
          }
        }
        return $nextCmdDate;
    }
}