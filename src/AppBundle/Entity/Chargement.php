<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chargement
 *
 * @ORM\Table(name="chargement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChargementRepository")
 */
class Chargement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSave", type="date")
     */
    private $dateSave;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;
 /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Produit")
   * @ORM\JoinColumn(nullable=false)
   */
  
    private $produit;

 /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
   * @ORM\JoinColumn(nullable=false)
   */
    private $user;
  

    private $produitId;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


public function getDataColums()
    {
        return [
             "produit"=>$this->getProduit()->getNom(),
             "date"=>$this->getDateSave()->format('m/d/Y h:i'),
             "quantite"=>$this->getQuantite(),
             "user"=> $this->user->getNom(),                 
            ];
    }

    /**
     * Set dateSave
     *
     * @param \DateTime $dateSave
     * @return Chargement
     */
    public function setDateSave($dateSave)
    {
        $this->dateSave = $dateSave;

        return $this;
    }

    /**
     * Get dateSave
     *
     * @return \DateTime 
     */
    public function getDateSave()
    {
        return $this->dateSave;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return Chargement
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set produit
     *
     * @param \AppBundle\Entity\Produit $produit
     * @return Chargement
     */
    public function setProduit(\AppBundle\Entity\Produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }


/**
     * Get produit
     *
     * @return  produitId
     */
    public function getProduit()
    {
        return $this->produit;
    }

/**
     * Set produit
     *
     * @param  $produit
     * @return Chargement
     */
    public function setProduitId($produit)
    {
        $this->produitId = $produit;

        return $this;
    }
    /**
     * Get produit
     *
     * @return  produitId
     */
    public function getProduitId()
    {
        return $this->produitId;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Client $user
     * @return Chargement
     */
    public function setUser(\AppBundle\Entity\Client $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\Client 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set journee
     *
     * @param \AppBundle\Entity\Journee $journee
     * @return Chargement
     */
    public function setJournee(\AppBundle\Entity\Journee $journee)
    {
        $this->journee = $journee;

        return $this;
    }

    /**
     * Get journee
     *
     * @return \AppBundle\Entity\Journee 
     */
    public function getJournee()
    {
        return $this->journee;
    }
}
