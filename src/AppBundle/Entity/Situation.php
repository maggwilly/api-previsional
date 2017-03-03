<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Situation
 *
 * @ORM\Table(name="situation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SituationRepository")
 */
class Situation
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
     * @var bool
     *
     * @ORM\Column(name="map", type="boolean", nullable=true)
     */
    private $map;

    /**
     * @var bool
     *
     * @ORM\Column(name="pre", type="boolean", nullable=true)
     */
    private $pre;

    /**
     * @var bool
     *
     * @ORM\Column(name="aff", type="boolean", nullable=true)
     */
    private $aff;

    /**
     * @var bool
     *
     * @ORM\Column(name="rpp", type="boolean", nullable=true)
     */
    private $rpp;

    /**
     * @var bool
     *
     * @ORM\Column(name="rpd", type="boolean", nullable=true)
     */
    private $rpd;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock;

        /**
     * @var int
     *
     * @ORM\Column(name="stockg", type="integer", nullable=true)
     */
    private $stockG;

    /**
     * @var string
     *
     * @ORM\Column(name="mvj",  type="integer", nullable=true)
     */
    private $mvj;

        /**
     * @var int
     *
     * @ORM\Column(name="ecl", type="integer", nullable=true)
     */
    private $ecl;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Produit",inversedBy="situations")
   * @ORM\JoinColumn(nullable=false)
   */
  
    private $produit;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Visite",inversedBy="situations")
   * @ORM\JoinColumn(nullable=false)
   */
  
    private $visite;


      /**
     * Constructor
     */
    public function __construct($id=null,$produit=null,$map=null,$pre=null,$aff=null, $stock=0,$stockG=0, $ecl=0,$mvj=0,$rpd=null,$rpp=null)
    {
      
      $this->id=$id;
      $this->produit = $produit;
      $this->map=$map;
      $this->pre=$pre;
      $this->aff=$aff;
      $this->stock=$stock;
      $this->stockG=$stockG;
       $this->ecl=$ecl;
       $this->mvj=$stock;
       $this->rpd=$rpd;
       $this->rpp=$rpp;
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
     * Set map
     *
     * @param boolean $map
     * @return Situation
     */
    public function setMap($map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map
     *
     * @return boolean 
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set pre
     *
     * @param boolean $pre
     * @return Situation
     */
    public function setPre($pre)
    {
        $this->pre = $pre;

        return $this;
    }

    /**
     * Get pre
     *
     * @return boolean 
     */
    public function getPre()
    {
        return $this->pre;
    }

    /**
     * Set aff
     *
     * @param boolean $aff
     * @return Situation
     */
    public function setAff($aff)
    {
        $this->aff = $aff;

        return $this;
    }

    /**
     * Get aff
     *
     * @return boolean 
     */
    public function getAff()
    {
        return $this->aff;
    }

    /**
     * Set rpp
     *
     * @param boolean $rpp
     * @return Situation
     */
    public function setRpp($rpp)
    {
        $this->rpp = $rpp;

        return $this;
    }

    /**
     * Get rpp
     *
     * @return boolean 
     */
    public function getRpp()
    {
        return $this->rpp;
    }

    /**
     * Set rpd
     *
     * @param boolean $rpd
     * @return Situation
     */
    public function setRpd($rpd)
    {
        $this->rpd = $rpd;

        return $this;
    }

    /**
     * Get rpd
     *
     * @return boolean 
     */
    public function getRpd()
    {
        return $this->rpd;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     * @return Situation
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



    /**
     * Set stock
     *
     * @param integer $stock
     * @return Situation
     */
    public function setStockG($stock)
    {
        $this->stockG = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStockG()
    {
        return $this->stock;
    }
    /**
     * Set ecl
     *
     * @param integer $ecl
     * @return Visite
     */
    public function setEcl($ecl)
    {
        $this->ecl = $ecl;

        return $this;
    }

    /**
     * Get ecl
     *
     * @return integer 
     */
    public function getEcl()
    {
        return $this->ecl;
    }

    /**
     * Set mvj
     *
     * @param integer $mvj
     * @return Situation
     */
    public function setMvj($mvj)
    {
        $this->mvj = $mvj;

        return $this;
    }

    /**
     * Get mvj
     *
     * @return integer 
     */
    public function getMvj()
    {
        return $this->mvj;
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Situation
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set produit
     *
     * @param \AppBundle\Entity\Produit $produit
     * @return Situation
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
     * Set visite
     *
     * @param \AppBundle\Entity\Visite $visite
     * @return Situation
     */
    public function setVisite(\AppBundle\Entity\Visite $visite)
    {
        $this->visite = $visite;

        return $this;
    }

    /**
     * Get visite
     *
     * @return \AppBundle\Entity\Visite 
     */
    public function getVisite()
    {
        return $this->visite;
    }
}
