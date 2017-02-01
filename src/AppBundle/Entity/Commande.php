<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeRepository")
 */
class Commande
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
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client",inversedBy="commandes")
   * @ORM\JoinColumn(nullable=true)
   */
    private $client;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client",inversedBy="commandePrises")
   * @ORM\JoinColumn(nullable=true)
   */
    private $user;
	
   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Plat",inversedBy="commandes")
   * @ORM\JoinColumn(nullable=false)
   */
  
    private $plat;

    private $platId;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSave", type="datetime")
     */
    private $dateSave;

    /**
     * @var bool
     *
     * @ORM\Column(name="piment", type="boolean",nullable=true)
     */
    private $piment;

    /**
     * @var bool
     *
     * @ORM\Column(name="a_cette_position", type="boolean",nullable=true)
     */
    private $aCettePosition;

     /**
     * @var string
     *
     * @ORM\Column(name="latLocal", type="string", length=255 ,nullable=true)
     */
    private $latLocal;

    /**
     * @var string
     *
     * @ORM\Column(name="longLocal", type="string", length=255, nullable=true)
     */
    private $longLocal;


    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status; //canceled, sended, payed, initialized


      /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255,nullable=true)
     */
    private $place;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_plat", type="integer")
     */
    private $nombrePlat;

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
     * Set dateSave
     *
     * @param \DateTime $dateSave
     * @return Commande
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
     * Set status
     *
     * @param string $status
     * @return Commande
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     * @return Commande
     */
    public function setClient(\AppBundle\Entity\Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set plat
     *
     * @param \AppBundle\Entity\Plat $plat
     * @return Commande
     */
    public function setPlat(\AppBundle\Entity\Plat $plat)
    {
        $this->plat = $plat;

        return $this;
    }

    /**
     * Get plat
     *
     * @return \AppBundle\Entity\Plat 
     */
    public function getPlat()
    {
        return $this->plat;
    }

  
    public function setPlatId($plat)
    {
        $this->platId = $plat;

        return $this;
    }

    public function getPlatId()
    {
        return $this->platId;
    }

    /**
     * Set piment
     *
     * @param boolean $piment
     * @return Commande
     */
    public function setPiment($piment)
    {
        $this->piment = $piment;

        return $this;
    }

    /**
     * Get piment
     *
     * @return boolean 
     */
    public function isPiment()
    {
        return $this->piment;
    }

    /**
     * Set aCettePosition
     *
     * @param boolean $aCettePosition
     * @return Commande
     */
    public function setACettePosition($aCettePosition)
    {
        $this->aCettePosition = $aCettePosition;

        return $this;
    }

    /**
     * Get aCettePosition
     *
     * @return boolean 
     */
    public function isACettePosition()
    {
        return $this->aCettePosition;
    }

    /**
     * Set latLocal
     *
     * @param string $latLocal
     * @return Commande
     */
    public function setLatLocal($latLocal)
    {
        $this->latLocal = $latLocal;

        return $this;
    }

    /**
     * Get latLocal
     *
     * @return string 
     */
    public function getLatLocal()
    {
        return $this->latLocal;
    }

    /**
     * Set longLocal
     *
     * @param string $longLocal
     * @return Commande
     */
    public function setLongLocal($longLocal)
    {
        $this->longLocal = $longLocal;

        return $this;
    }

    /**
     * Get longLocal
     *
     * @return string 
     */
    public function getLongLocal()
    {
        return $this->longLocal;
    }

    /**
     * Get piment
     *
     * @return boolean 
     */
    public function getPiment()
    {
        return $this->piment;
    }

    /**
     * Get aCettePosition
     *
     * @return boolean 
     */
    public function getACettePosition()
    {
        return $this->aCettePosition;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return Commande
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set nombrePlat
     *
     * @param integer $nombrePlat
     * @return Commande
     */
    public function setNombrePlat($nombrePlat)
    {
        $this->nombrePlat = $nombrePlat;

        return $this;
    }

    /**
     * Get nombrePlat
     *
     * @return integer 
     */
    public function getNombrePlat()
    {
        return $this->nombrePlat;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Client $user
     * @return Commande
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
}
