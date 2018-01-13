<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Concours
 *
 * @ORM\Table(name="concours_ecole")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConcoursRepository")
 */
class Concours
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
     * @ORM\Column(name="ecole", type="string", length=255)
     */
    private $ecole;

    /**
     * @var string
     *
     * @ORM\Column(name="abreviation", type="string", length=255, nullable=true)
     */
    private $abreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionEcole", type="text", length=255, nullable=true)
     */
    private $descriptionEcole;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionConcours", type="text", length=255, nullable=true)
     */
    private $descriptionConcours;

    /**
     * @var string
     *
     * @ORM\Column(name="contacts", type="string", length=255, nullable=true)
     */
    private $contacts;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text",  nullable=true)
     */
    private $imageUrl;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $imageEntity;

     /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Session", mappedBy="concours", cascade={"persist","remove"})
   */
    private $sessions;

        /**
     * @var string
     *
     * @ORM\Column(name="serie", type="string", length=255, nullable=true)
     */
    private $serie;

        /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255, nullable=true)
     */
    private $niveau;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_max", type="date", nullable=true)
     */
    private $dateMax;

    /**
     * Constructor
     */
    public function __construct(Programme $programme=null)
    {
         
        $this->sessions = new \Doctrine\Common\Collections\ArrayCollection();
        if($programme!=null){
        $this->nom=$programme->getNom();
        $this->ecole=$programme->getEcole();
        $this->abreviation= $programme->getAbreviation();
        $this->descriptionEcole= $programme->getDescriptionEcole();
        $this->descriptionConcours= $programme->getDescriptionConcours();
        $this->imageUrl= $programme->getImage();
        $this->contacts= $programme->getContact();
        $session = new Session($this,$programme);
        $this-> addSession($session);
    }

        

       

    }
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
     * @return Concours
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
     * Set ecole
     *
     * @param string $ecole
     *
     * @return Concours
     */
    public function setEcole($ecole)
    {
        $this->ecole = $ecole;

        return $this;
    }

    /**
     * Get ecole
     *
     * @return string
     */
    public function getEcole()
    {
        return $this->ecole;
    }

    /**
     * Set abreviation
     *
     * @param string $abreviation
     *
     * @return Concours
     */
    public function setAbreviation($abreviation)
    {
        $this->abreviation = $abreviation;

        return $this;
    }

    /**
     * Get abreviation
     *
     * @return string
     */
    public function getAbreviation()
    {
        return $this->abreviation;
    }

    /**
     * Set descriptionEcole
     *
     * @param string $descriptionEcole
     *
     * @return Concours
     */
    public function setDescriptionEcole($descriptionEcole)
    {
        $this->descriptionEcole = $descriptionEcole;

        return $this;
    }

    /**
     * Get descriptionEcole
     *
     * @return string
     */
    public function getDescriptionEcole()
    {
        return $this->descriptionEcole;
    }

    /**
     * Set descriptionConcours
     *
     * @param string $descriptionConcours
     *
     * @return Concours
     */
    public function setDescriptionConcours($descriptionConcours)
    {
        $this->descriptionConcours = $descriptionConcours;

        return $this;
    }

    /**
     * Get descriptionConcours
     *
     * @return string
     */
    public function getDescriptionConcours()
    {
        return $this->descriptionConcours;
    }

    /**
     * Set contacts
     *
     * @param string $contacts
     *
     * @return Concours
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * Get contacts
     *
     * @return string
     */
    public function getContacts()
    {
        return $this->contacts;
    }


    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Concours
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        if($this->imageEntity!=null)
           return $this->imageUrl=$this->imageEntity->getUrl();
        return $this->imageUrl;
    }

    /**
     * Set imageEntity
     *
     * @param \AppBundle\Entity\Image $imageEntity
     *
     * @return Concours
     */
    public function setImageEntity(\AppBundle\Entity\Image $imageEntity = null)
    {
        $this->imageEntity = $imageEntity;

        return $this;
    }

    /**
     * Get imageEntity
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImageEntity()
    {
        return $this->imageEntity;
    }

    /**
     * Add session
     *
     * @param \AppBundle\Entity\Session $session
     *
     * @return Concours
     */
    public function addSession(\AppBundle\Entity\Session $session)
    {
       $session->setConcours($this);
        $this->sessions[] = $session;

        return $this;
    }

    /**
     * Remove session
     *
     * @param \AppBundle\Entity\Session $session
     */
    public function removeSession(\AppBundle\Entity\Session $session)
    {
        $this->sessions->removeElement($session);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSessions()
    {
        return $this->sessions;
    }

     /**
     * Set serie
     *
     * @param string $serie
     *
     * @return Session
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set niveau
     *
     * @param string $niveau
     *
     * @return Session
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set dateMax
     *
     * @param \DateTime $dateMax
     *
     * @return Session
     */
    public function setDateMax($dateMax)
    {
        $this->dateMax = $dateMax;

        return $this;
    }

    /**
     * Get dateMax
     *
     * @return \DateTime
     */
    public function getDateMax()
    {
        return $this->dateMax;
    }   
}
