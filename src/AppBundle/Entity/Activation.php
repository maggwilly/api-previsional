<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activation
 *
 * @ORM\Table(name="activation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActivationRepository")
 */
class Activation
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
     * @ORM\Column(name="parametrage", type="boolean")
     */
    private $parametrage;

   /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    /**
     * @var string
     *
     * @ORM\Column(name="raison", type="string", length=255, nullable=true)
     */
    private $raison;

       /**
     * @var string
     *
     * @ORM\Column(name="provisionning", type="integer", nullable=true)
     */
    private $provisionning;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   */
    private $user;

    /**
   * @ORM\OneToOne(targetEntity="AppBundle\Entity\Client")
   */
    private $client;
    
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
     * Set parametrage
     *
     * @param boolean $parametrage
     * @return Activation
     */
    public function setParametrage($parametrage)
    {
        $this->parametrage = $parametrage;

        return $this;
    }

    /**
     * Get parametrage
     *
     * @return boolean 
     */
    public function getParametrage()
    {
        return $this->parametrage;
    }

    /**
     * Set raison
     *
     * @param string $raison
     * @return Activation
     */
    public function setRaison($raison)
    {
        $this->raison = $raison;

        return $this;
    }

    /**
     * Get raison
     *
     * @return string 
     */
    public function getRaison()
    {
        return $this->raison;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Activation
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
     * @return Activation
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
     * @return Activation
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
     * Set provisionning
     *
     * @param integer $provisionning
     * @return Activation
     */
    public function setProvisionning($provisionning)
    {
        $this->provisionning = $provisionning;

        return $this;
    }

    /**
     * Get provisionning
     *
     * @return integer 
     */
    public function getProvisionning()
    {
        return $this->provisionning;
    }
}
