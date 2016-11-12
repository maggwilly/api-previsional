<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProduitRepository")
 */
class Produit implements JsonSerializable
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
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="conditionement", type="string", length=255)
     */
    private $conditionement;

    /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\CommandeProduit", mappedBy="produit")
   */
    private $commandesProduit;


    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'prix' => $this->getPrix(),
            'nom' => $this->getNom(),
            'conditionement' => $this->getConditionement(),          
        ];
    }
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
     * Set prix
     *
     * @param integer $prix
     * @return Produit
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Produit
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set conditionement
     *
     * @param string $conditionement
     * @return Produit
     */
    public function setConditionement($conditionement)
    {
        $this->conditionement = $conditionement;

        return $this;
    }

    /**
     * Get conditionement
     *
     * @return string 
     */
    public function getConditionement()
    {
        return $this->conditionement;
    }
    /**
     * Constructor
     */
    public function __construct($nom=null,$prix=0)
    {
        $this->commandesProduit = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conditionement="unité";
         $this->nom=$nom;
         $this->prix=$prix;
    }

    /**
     * Add commandesProduit
     *
     * @param \AppBundle\Entity\Commande $commandesProduit
     * @return Produit
     */
    public function addCommandesProduit(\AppBundle\Entity\Commande $commandesProduit)
    {
        $this->commandesProduit[] = $commandesProduit;

        return $this;
    }

    /**
     * Remove commandesProduit
     *
     * @param \AppBundle\Entity\Commande $commandesProduit
     */
    public function removeCommandesProduit(\AppBundle\Entity\Commande $commandesProduit)
    {
        $this->commandesProduit->removeElement($commandesProduit);
    }

    /**
     * Get commandesProduit
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommandesProduit()
    {
        return $this->commandesProduit;
    }
}
