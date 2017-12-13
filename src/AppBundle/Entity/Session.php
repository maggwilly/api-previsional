<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 *
 * @ORM\Table(name="session")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SessionRepository")
 */
class Session
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
     * @ORM\Column(name="nom_concours", type="string", length=255, nullable=true)
     */
    private $nomConcours;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    /**
     * @var string
     *
     * @ORM\Column(name="annee", type="integer",  nullable=true)
     */
    private $annee;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="abreviation", type="string", length=255, nullable=true)
     */
    private $abreviation;


    /**
     * @var int
     *
     * @ORM\Column(name="archived", type="boolean", nullable=true)
     */
    private $archived;   

    /**
     * @var int
     *
     * @ORM\Column(name="nombrePlace", type="integer", nullable=true)
     */
    private $nombrePlace;

    /**
     * @var int
     *
     * @ORM\Column(name="nombreInscrit", type="integer", nullable=true)
     */
    private $nombreInscrit;

        /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateLancement", type="date", nullable=true)
     */
    private $dateLancement;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Concours",inversedBy="sessions")
     */
    private $concours;

          /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Programme")
     */
    private $preparation;

      /**
   * @ORM\OneToMany(targetEntity="Pwm\AdminBundle\Entity\Abonnement", mappedBy="session", cascade={"persist","remove"})
   */
    private $abonnements;  


      /**
   * @ORM\ManyToMany(targetEntity="Pwm\AdminBundle\Entity\Info",  cascade={"persist","remove"})
   * @ORM\JoinTable(joinColumns={ @ORM\JoinColumn(name="session_id",referencedColumnName="id")},
                    inverseJoinColumns={ @ORM\JoinColumn(name="info_uid",referencedColumnName="uid")}
             )
   */
    private $infos;  

     /**
     * @ORM\ManyToOne(targetEntity="Pwm\AdminBundle\Entity\Price", cascade={"persist", "remove"})
     */
    private $price;
  /**
     * Constructor
     */
    public function __construct(Concours $concours,Programme $programme=null)
    {
     $date=new \DateTime();
    // $this->annee=$date->getYear();
     $this->date=$date;
     $this->archived=false;
     $this->concours= $concours;
     $this->infos = new \Doctrine\Common\Collections\ArrayCollection();
     $this->abonnements = new \Doctrine\Common\Collections\ArrayCollection();
      if($programme!=null){
          $this->preparation= $programme;
            $this->dateConcours= $programme->getDateConcours();
             $this->dateDossier= $programme->getDateDossier();
              $this->nombrePlace= $programme->getNombrePlace();
               $this->nombreInscrit= $programme->getNombreInscrit();
                $this->type= $programme->getType();
                 $this->nom= $programme->getSession();
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
     * Set nombrePlace
     *
     * @param integer $nombrePlace
     *
     * @return Session
     */
    public function setNombrePlace($nombrePlace)
    {
        $this->nombrePlace = $nombrePlace;

        return $this;
    }

    /**
     * Get nombrePlace
     *
     * @return int
     */
    public function getNombrePlace()
    {
        return $this->nombrePlace;
    }

    /**
     * Set nombreInscrit
     *
     * @param integer $nombreInscrit
     *
     * @return Session
     */
    public function setNombreInscrit($nombreInscrit)
    {
        $this->nombreInscrit = $nombreInscrit;

        return $this;
    }

    /**
     * Get nombreInscrit
     *
     * @return int
     */
    public function getNombreInscrit()
    {
        return $this->nombreInscrit;
    }

    /**
     * Set dateConcours
     *
     * @param \DateTime $dateConcours
     *
     * @return Session
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
     * Set dateDossier
     *
     * @param \DateTime $dateDossier
     *
     * @return Session
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Session
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
     * Set abreviation
     *
     * @param string $abreviation
     *
     * @return Session
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
        if($this->abreviation!=null)
             return $this->abreviation;
        return $this->concours->getAbreviation();
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Session
     */
    public function setPrice(\Pwm\AdminBundle\Entity\Price $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set dateLancement
     *
     * @param \DateTime $dateLancement
     *
     * @return Session
     */
    public function setDateLancement($dateLancement)
    {
        $this->dateLancement = $dateLancement;

        return $this;
    }

    /**
     * Get dateLancement
     *
     * @return \DateTime
     */
    public function getDateLancement()
    {
        return $this->dateLancement;
    }

    /**
     * Set concours
     *
     * @param \AppBundle\Entity\Concours $concours
     *
     * @return Session
     */
    public function setConcours(\AppBundle\Entity\Concours $concours = null)
    {
        $this->concours = $concours;

        return $this;
    }

    /**
     * Get concours
     *
     * @return \AppBundle\Entity\Concours
     */
    public function getConcours()
    {
        return $this->concours;
    }





    /**
     * Set nomConcours
     *
     * @param string $nomConcours
     *
     * @return Session
     */
    public function setNomConcours($nomConcours)
    {
    
        $this->nomConcours = $nomConcours;

        return $this;
    }

    /**
     * Get nomConcours
     *
     * @return string
     */
    public function getNomConcours()
    {
    return $this->concours->getNom().' '.$this->getNom();  
    }

    /**
     * Set annee
     *
     * @param integer $annee
     *
     * @return Session
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return integer
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Session
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
     * Set archived
     *
     * @param boolean $archived
     *
     * @return Session
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return boolean
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Session
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
     * Set preparation
     *
     * @param \AppBundle\Entity\Programme $preparation
     *
     * @return Session
     */
    public function setPreparation(\AppBundle\Entity\Programme $preparation = null)
    {
        $this->preparation = $preparation;

        return $this;
    }

    /**
     * Get preparation
     *
     * @return \AppBundle\Entity\Programme
     */
    public function getPreparation()
    {
        return $this->preparation;
    }

    /**
     * Add abonnement
     *
     * @param \Pwm\AdminBundle\Entity\Abonnement $abonnement
     *
     * @return Session
     */
    public function addAbonnement(\Pwm\AdminBundle\Entity\Abonnement $abonnement)
    {
        $this->abonnements[] = $abonnement;

        return $this;
    }

    /**
     * Remove abonnement
     *
     * @param \Pwm\AdminBundle\Entity\Abonnement $abonnement
     */
    public function removeAbonnement(\Pwm\AdminBundle\Entity\Abonnement $abonnement)
    {
        $this->abonnements->removeElement($abonnement);
    }

    /**
     * Get abonnements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAbonnements()
    {
        return $this->abonnements;
    }

    /**
     * Add info
     *
     * @param \Pwm\AdminBundle\Entity\Info $info
     *
     * @return Session
     */
    public function addInfo(\Pwm\AdminBundle\Entity\Info $info)
    {
        $this->infos[] = $info;

        return $this;
    }

    /**
     * Remove info
     *
     * @param \Pwm\AdminBundle\Entity\Info $info
     */
    public function removeInfo(\Pwm\AdminBundle\Entity\Info $info)
    {
        foreach ($this->infos as $key => $value) {
            if($info->getUid()==$value->getUid())
                unset($this->infos[$key]);
        }  
    }

    /**
     * Get infos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInfos()
    {
        return $this->infos;
    }
}
