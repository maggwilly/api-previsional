<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phoning
 *
 * @ORM\Table(name="phoning")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhoningRepository")
 */
class Phoning
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
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="time")
     */
    private $heure;

    /**
     * @var string
     *
     * @ORM\Column(name="issu", type="string", length=255)
     */
    private $issu;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   */
    private $user;

  /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
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
     * Set date
     *
     * @param \DateTime $date
     * @return Phoning
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
     * Set heure
     *
     * @param \DateTime $heure
     * @return Phoning
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * Get heure
     *
     * @return \DateTime 
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * Set issu
     *
     * @param string $issu
     * @return Phoning
     */
    public function setIssu($issu)
    {
        $this->issu = $issu;

        return $this;
    }

    /**
     * Get issu
     *
     * @return string 
     */
    public function getIssu()
    {
        return $this->issu;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Phoning
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
     * @return Phoning
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


}
