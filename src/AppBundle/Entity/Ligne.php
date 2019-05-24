<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ligne
 *
 * @ORM\Table(name="ligne")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LigneRepository")
 */
class Ligne
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
     * @ORM\Column(name="acn", type="boolean", nullable=true)
     */
    private $acn;

        /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock;
    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Produit",inversedBy="lignes")
   * @ORM\JoinColumn(nullable=false)
   */
    private $produit;
    
        /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Commende",inversedBy="lignes")
   * @ORM\JoinColumn(nullable=false)
   */
    private $commende;
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Ligne
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set produit
     *
     * @param \AppBundle\Entity\Produit $produit
     *
     * @return Ligne
     */
    public function setProduit(\AppBundle\Entity\Produit $produit = null)
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
     * Set commende
     *
     * @param \AppBundle\Entity\Commende $commende
     *
     * @return Ligne
     */
    public function setCommende(\AppBundle\Entity\Commende $commende = null)
    {
        $this->commende = $commende;

        return $this;
    }

    /**
     * Get commende
     *
     * @return \AppBundle\Entity\Commende
     */
    public function getCommende()
    {
        return $this->commende;
    }

    /**
     * Set acn
     *
     * @param boolean $acn
     *
     * @return Ligne
     */
    public function setAcn($acn)
    {
        $this->acn = $acn;

        return $this;
    }

    /**
     * Get acn
     *
     * @return boolean
     */
    public function getAcn()
    {
        return $this->acn;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Ligne
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }
}
