<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandeProduit
 *
 * @ORM\Table(name="commande_produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeProduitRepository")
 */
class CommandeProduit
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
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSave", type="datetime")
     */
    private $dateSave;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Produit",inversedBy="commandesProduit")
   * @ORM\JoinColumn(nullable=false)
   */
  
    private $produit;


   /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\CommandeClient",inversedBy="commandesProduit")
   * @ORM\JoinColumn(nullable=false)
   */
  
    private $CommandeClient;


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

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return CommandeProduit
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
     * Set dateSave
     *
     * @param \DateTime $dateSave
     * @return CommandeProduit
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
     * Set produit
     *
     * @param \AppBundle\Entity\Produit $produit
     * @return CommandeProduit
     */
    public function setProduit(\AppBundle\Entity\Produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \AppBundle\Entity\Produit 
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set CommandeClient
     *
     * @param \AppBundle\Entity\CommandeClient $commandeClient
     * @return CommandeProduit
     */
    public function setCommandeClient(\AppBundle\Entity\CommandeClient $commandeClient)
    {
        $this->CommandeClient = $commandeClient;

        return $this;
    }

    /**
     * Get CommandeClient
     *
     * @return \AppBundle\Entity\CommandeClient 
     */
    public function getCommandeClient()
    {
        return $this->CommandeClient;
    }
}
