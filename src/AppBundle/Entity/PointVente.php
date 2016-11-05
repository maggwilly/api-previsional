<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PointVente
 *
 * @ORM\Table(name="point_vente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PointVenteRepository")
 */
class PointVente
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
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255,unique=true)
     */
    private $telephone;

     /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
   * @ORM\JoinColumn(nullable=false)
   */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="quartier", type="string", length=255, nullable=true)
     */
    private $quartier;

     /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\CommandeClient", mappedBy="pointVente")
   */
    private $commandesClient;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=500)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255, nullable=true)
     */
    private $latitude;



   
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
     * @return PointVente
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
     * Set telephone
     *
     * @param string $telephone
     * @return PointVente
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return PointVente
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set quartier
     *
     * @param string $quartier
     * @return PointVente
     */
    public function setQuartier($quartier)
    {
        $this->quartier = $quartier;

        return $this;
    }

    /**
     * Get quartier
     *
     * @return string 
     */
    public function getQuartier()
    {
        return $this->quartier;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return PointVente
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return PointVente
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return PointVente
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
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
     * @return PointVente
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
     * @return PointVente
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
