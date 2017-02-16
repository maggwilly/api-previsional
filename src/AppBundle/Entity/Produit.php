<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProduitRepository")
 */
class Produit
{
   /**
     * @var string
     *
     * @ORM\Column(name="id",  type="string", length=255)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="dossier", type="string", length=255)
     */
    private $dossier;

        /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Situation", mappedBy="produit", cascade={"persist","remove"})
   */
    private $situations;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Produit", cascade={"persist","remove"})
     * @var User
     */
    protected $concurent;


public function __construct($nom=null,$dossier, \AppBundle\Entity\Produit $concurent = null)
    {
      $this->nom=$nom;
      $this->id=$nom;
      $this->dossier=$dossier;
      $this->concurent=$concurent;
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
     * Set dossier
     *
     * @param string $dossier
     * @return Produit
     */
    public function setDossier($dossier)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier
     *
     * @return string 
     */
    public function getDossier()
    {
        return $this->dossier;
    }

    /**
     * Add situations
     *
     * @param \AppBundle\Entity\Situation $situations
     * @return Produit
     */
    public function addSituation(\AppBundle\Entity\Situation $situations)
    {
        $this->situations[] = $situations;

        return $this;
    }

    /**
     * Remove situations
     *
     * @param \AppBundle\Entity\Situation $situations
     */
    public function removeSituation(\AppBundle\Entity\Situation $situations)
    {
        $this->situations->removeElement($situations);
    }

    /**
     * Get situations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSituations()
    {
        return $this->situations;
    }

    /**
     * Set concurent
     *
     * @param \AppBundle\Entity\Produit $concurent
     * @return Produit
     */
    public function setConcurent(\AppBundle\Entity\Produit $concurent = null)
    {
        $this->concurent = $concurent;

        return $this;
    }

    /**
     * Get concurent
     *
     * @return \AppBundle\Entity\Produit 
     */
    public function getConcurent()
    {
        return $this->concurent;
    }
}
