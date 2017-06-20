<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Concours
 *
 * @ORM\Table(name="concours")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgrammeRepository")
 */
class Programme
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
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

        /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Programme" )
   */
    private $auMoinsdeMemeQue;

    private $programme;
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
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="session", type="string", length=255, nullable=true)
     */
    private $session;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionEcole", type="text",  nullable=true)
     */
    private $descriptionEcole;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionConcours", type="text",  nullable=true)
     */
    private $descriptionConcours;

    /**
     * @var int
     *
     * @ORM\Column(name="nombrePlace", type="integer",  nullable=true)
     */
    private $nombrePlace;

        /**
     * @var int
     *
     * @ORM\Column(name="nombreInscrit", type="integer",  nullable=true)
     */
    private $nombreInscrit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateConcours", type="date", nullable=true)
     */
    private $dateConcours;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDossier", type="date", nullable=true)
     */
    private $dateDossier;

     /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Objectif", mappedBy="programme", cascade={"persist","remove"})
   */
    private $liens;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text",  nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=255,  nullable=true)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="resultats", type="string", length=255,  nullable=true)
     */
    private $resultats;

    /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Matiere", mappedBy="programme", cascade={"persist","remove"})
   */
    private $matieres;


    /**
     * Constructor
     */
    public function __construct()
    {
    $this->matieres = new \Doctrine\Common\Collections\ArrayCollection();
    $this->liens = new \Doctrine\Common\Collections\ArrayCollection();
    $this->date=new \DateTime();
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
     * Set nom
     *
     * @param string $nom
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
     * @return Concours
     */
    public function setAuMoinsdeMemeQue(\AppBundle\Entity\Programme $programme= null)
    {
        $this->auMoinsdeMemeQue = $programme;

        return $this;
    }

    /**
     * Get ecole
     *
     * @return string 
     */
    public function getAuMoinsdeMemeQue(){
    if($this->auMoinsdeMemeQue==$this)
            return null;
        return $this->auMoinsdeMemeQue;
    
    }


    /**
     * Set ecole
     *
     * @param string $ecole
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
     * Set type
     *
     * @param string $type
     * @return Concours
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
     * Set session
     *
     * @param string $session
     * @return Concours
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return string 
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set descriptionEcole
     *
     * @param string $descriptionEcole
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
     * Set nombrePlace
     *
     * @param integer $nombrePlace
     * @return Concours
     */
    public function setNombrePlace($nombrePlace)
    {
        $this->nombrePlace = $nombrePlace;

        return $this;
    }

    /**
     * Get nombrePlace
     *
     * @return integer 
     */
    public function getNombrePlace()
    {
        return $this->nombrePlace;
    }

    /**
     * Set dateConcours
     *
     * @param \DateTime $dateConcours
     * @return Concours
     */
    public function setDateConcours($dateConcours)
    {
        $this->dateConcours = $dateConcours;

        return $this;
    }

    /**
     * Get dateConcours
     *
     * @return \DateTime 
     */
    public function getDateConcours()
    {
        return $this->dateConcours;
    }

    /**
     * Get dateConcours
     *
     * @return \DateTime 
     */
    public function getDateConcoursFormated()
    {
        return $this->dateConcours->format('Y-m-dTH:i');
    }
    /**
     * Set dateDossier
     *
     * @param \DateTime $dateDossier
     * @return Concours
     */
    public function setDateDossier($dateDossier)
    {
        $this->dateDossier = $dateDossier;

        return $this;
    }

    /**
     * Get dateDossier
     *
     * @return \DateTime 
     */
    public function getDateDossier()
    {
        return $this->dateDossier;
    }

        /**
     * Get dateDossier
     *
     * @return \DateTime 
     */
    public function getDateDossierFormated()
    {
        return $this->dateDossier->format('Y-m-dTH:i');
    }

    /**
     * Set lien
     *
     * @param string $lien
     * @return Concours
     */
    public function setLien($lien)
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * Get lien
     *
     * @return string 
     */
    public function getLien()
    {
        return $this->lien;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Concours
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Concours
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set resultats
     *
     * @param string $resultats
     * @return Concours
     */
    public function setResultats($resultats)
    {
        $this->resultats = $resultats;

        return $this;
    }

    /**
     * Get resultats
     *
     * @return string 
     */
    public function getResultats()
    {
        return $this->resultats;
    }


    /**
     * Add matieres
     *
     * @param \AppBundle\Entity\Matiere $matieres
     * @return Concours
     */
    public function addMatiere(\AppBundle\Entity\Matiere $matieres)
    {
        $this->matieres[] = $matieres;

        return $this;
    }

    /**
     * Remove matieres
     *
     * @param \AppBundle\Entity\Matiere $matieres
     */
    public function removeMatiere(\AppBundle\Entity\Matiere $matieres)
    {
        $this->matieres->removeElement($matieres);
    }

    /**
     * Get matieres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMatieres()
    { 
        if($this->auMoinsdeMemeQue==$this||$this->auMoinsdeMemeQue==null)
              return $this->matieres;
            return $this->auMoinsdeMemeQue->getMatieres();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getProgramme()
    {
        if($this->auMoinsdeMemeQue!=null &&$this->auMoinsdeMemeQue!=$this)
            return  $this->programme=$this->auMoinsdeMemeQue->getId();
        return $this->programme=$this->id;
    }

        /**
     * Get id
     *
     * @return integer 
     */
    public function getPrice()
    {
        if($this->price!=null)
              return $this->price;
        if($this->auMoinsdeMemeQue!=null &&$this->auMoinsdeMemeQue!=$this)
            return $this->price=$this->auMoinsdeMemeQue->getPrice();
    return $this->price;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Etape
     */
    public function setPrice($date)
    {
        $this->price = $date;

        return $this;
    }
    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Etape
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
     * Set nombreInscrit
     *
     * @param integer $nombreInscrit
     *
     * @return Programme
     */
    public function setNombreInscrit($nombreInscrit)
    {
        $this->nombreInscrit = $nombreInscrit;

        return $this;
    }

    /**
     * Set nombreInscrit
     *
     * @param integer $nombreInscrit
     *
     * @return Programme
     */
    public function addInscrit()
    {
        $this->nombreInscrit += 1;

        return $this;
    }
    /**
     * Get nombreInscrit
     *
     * @return integer
     */
    public function getNombreInscrit()
    {
        return $this->nombreInscrit;
    }

    /**
     * Add lien
     *
     * @param \AppBundle\Entity\Objectif $lien
     *
     * @return Programme
     */
    public function addLien(\AppBundle\Entity\Objectif $lien)
    {
        $this->liens[] = $lien;

        return $this;
    }

    /**
     * Remove lien
     *
     * @param \AppBundle\Entity\Objectif $lien
     */
    public function removeLien(\AppBundle\Entity\Objectif $lien)
    {
        $this->liens->removeElement($lien);
    }

    /**
     * Get liens
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLiens()
    {
        return $this->liens;
    }
}
