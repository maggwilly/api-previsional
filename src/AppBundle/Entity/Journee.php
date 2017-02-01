<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Journee
 *
 * @ORM\Table(name="journee")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JourneeRepository")
 */
class Journee
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
     * @ORM\Column(name="date_save", type="date")
     */
    private $date;

    /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\CommandeClient", mappedBy="journee")
   */
    private $commandesClient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut", type="datetime")
     */
    private $debut;

    /**
     * @var string
     *
     * @ORM\Column(name="longDebut", type="string", length=255, nullable=true)
     */
    private $longDebut;

    /**
     * @var string
     *
     * @ORM\Column(name="latDebut", type="string", length=255, nullable=true)
     */
    private $latDebut;


   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
   * @ORM\JoinColumn(nullable=false)
   */
    private $user;
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
     * Set date
     *
     * @param \DateTime $date
     * @return Journee
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
     * Set debut
     *
     * @param \DateTime $debut
     * @return Journee
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime 
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set longDebut
     *
     * @param string $longDebut
     * @return Journee
     */
    public function setLongDebut($longDebut)
    {
        $this->longDebut = $longDebut;

        return $this;
    }

    /**
     * Get longDebut
     *
     * @return string 
     */
    public function getLongDebut()
    {
        return $this->longDebut;
    }

    /**
     * Set latDebut
     *
     * @param string $latDebut
     * @return Journee
     */
    public function setLatDebut($latDebut)
    {
        $this->latDebut = $latDebut;

        return $this;
    }

    /**
     * Get latDebut
     *
     * @return string 
     */
    public function getLatDebut()
    {
        return $this->latDebut;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commandesClient = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add commandesClient
     *
     * @param \AppBundle\Entity\CommandeClient $commandesClient
     * @return Journee
     */
    public function addCommandesClient(\AppBundle\Entity\CommandeClient $commandesClient)
    {
        $this->commandesClient[] = $commandesClient;

        return $this;
    }

    /**
     * Remove commandesClient
     *
     * @param \AppBundle\Entity\CommandeClient $commandesClient
     */
    public function removeCommandesClient(\AppBundle\Entity\CommandeClient $commandesClient)
    {
        $this->commandesClient->removeElement($commandesClient);
    }

    /**
     * Get commandesClient
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommandesClient()
    {
        return $this->commandesClient;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Client $user
     * @return Journee
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
