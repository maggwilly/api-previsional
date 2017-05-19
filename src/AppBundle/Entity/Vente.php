<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vente
 *
 * @ORM\Table(name="vente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VenteRepository")
 */
class Vente
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
     * @var string
     *
     * @ORM\Column(name="imei", type="string", length=255)
     */
    private $imei;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

   /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   */
    private $user;

        /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
   */
    private $client;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Telephone")
   */
    private $telephone;
    
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
     * Set imei
     *
     * @param string $imei
     * @return Vente
     */
    public function setImei($imei)
    {
        $this->imei = $imei;

        return $this;
    }

    /**
     * Get imei
     *
     * @return string 
     */
    public function getImei()
    {
        return $this->imei;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     * @return Vente
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Vente
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     * @return Vente
     */
    public function setClient(\AppBundle\Entity\Client $client = null)
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
     * Set date
     *
     * @param \DateTime $date
     * @return Vente
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set telephone
     *
     * @param \AppBundle\Entity\Telephone $telephone
     * @return Vente
     */
    public function setTelephone(\AppBundle\Entity\Telephone $telephone = null)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return \AppBundle\Entity\Telephone 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
}
