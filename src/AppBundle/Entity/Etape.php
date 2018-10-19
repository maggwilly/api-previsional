<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etape
 *
 * @ORM\Table(name="etape")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EtapeRepository")
 */
class Etape
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ressources", type="text", nullable=true)
     */
    private $ressources;

   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Campagne" ,inversedBy="etapes")
   */
    private $campagne;

         /**
     * @var string
     *
     * @ORM\Column(name="datedebut", type="datetime")
     */
    private $datedebut;


    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   */
  private $user;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Etape
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
     * Set description
     *
     * @param string $description
     *
     * @return Etape
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ressources
     *
     * @param string $ressources
     *
     * @return Etape
     */
    public function setRessources($ressources)
    {
        $this->ressources = $ressources;

        return $this;
    }

    /**
     * Get ressources
     *
     * @return string
     */
    public function getRessources()
    {
        return $this->ressources;
    }

    /**
     * Set campagne
     *
     * @param \AppBundle\Entity\Campagne $campagne
     *
     * @return Etape
     */
    public function setCampagne(\AppBundle\Entity\Campagne $campagne = null)
    {
        $this->campagne = $campagne;

        return $this;
    }

    /**
     * Get campagne
     *
     * @return \AppBundle\Entity\Campagne
     */
    public function getCampagne()
    {
        return $this->campagne;
    }
    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Question
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
     * Set datedebut
     *
     * @param \DateTime $datedebut
     *
     * @return Campagne
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return \DateTime
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }    
}
