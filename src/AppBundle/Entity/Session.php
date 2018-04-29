<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pwm\AdminBundle\Entity\Groupe;
/**
 * Session
 *
 * @ORM\Table(name="session")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SessionRepository")
  * @ORM\HasLifecycleCallbacks
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
     * @ORM\Column(name="nom_concours", type="string", length=512, options={"default" : "groupe"},  nullable=true)
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
     * @var int
     *
     * @ORM\Column(name="archived", type="boolean", nullable=true)
     */
    private $archived;   
    

    private $shouldAlert;

    private $newressource; 
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
   * @ORM\ManyToMany(targetEntity="Pwm\AdminBundle\Entity\Info",  cascade={"persist"})
   * @ORM\JoinTable(joinColumns={ @ORM\JoinColumn(name="session_id",referencedColumnName="id")},
                    inverseJoinColumns={ @ORM\JoinColumn(name="info_uid",referencedColumnName="uid")})
   */
    private $infos;  

     /**
     * @ORM\ManyToOne(targetEntity="Pwm\AdminBundle\Entity\Price", cascade={"persist", "remove"})
     */
    private $price;

        /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Objectif", mappedBy="programme", cascade={"persist","remove"})
   */
    private $liens; 

    /**
   * @ORM\OneToOne(targetEntity="Pwm\AdminBundle\Entity\Groupe", mappedBy="session", cascade={"persist","remove"})
   */
    private $groupe; 

        /**
     * @var string
     *
     * @ORM\Column(name="uid", type="string", length=255, nullable=true)
     */
    private $owner;

        /**
   * @ORM\ManyToMany(targetEntity="Pwm\AdminBundle\Entity\Ressource", inversedBy="sessions", cascade={"persist"})
   */
    private $ressources; 

    /**
   * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Partie", inversedBy="sessions", cascade={"persist"})
   */
    private $parties; 

   /**
     * @var string
     *
     * @ORM\Column(name="discussionName", type="string", length=255, options={"default" : "Groupe"})
     */
    private $discussionName;


    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Pwm\MessagerBundle\Entity\Notification", cascade={"persist"})
     */
    private $articleDescriptif;

  /**
     * Constructor
     */
    public function __construct(Concours $concours, Programme $programme=null)
    {
     $date=new \DateTime();
     $this->date=$date;
     $this->nombreInscrit=0;
     $this->archived=false;
     $this->shouldAlert=false;
     $this->concours= $concours;
     $this->nomConcours=$concours->getNom();
     $this->abreviation=$concours->getAbreviation();
     $this->infos = new \Doctrine\Common\Collections\ArrayCollection();
     $this->abonnements = new \Doctrine\Common\Collections\ArrayCollection();
     $this->liens = new \Doctrine\Common\Collections\ArrayCollection();
     $this->parties = new \Doctrine\Common\Collections\ArrayCollection();
     $this->ressources = new \Doctrine\Common\Collections\ArrayCollection();
    }


      /**
    * @ORM\PrePersist()
    */
    public function PrePersist(){
      $this->groupe= new Groupe($this->nomConcours,$this);
        $this->discussionName =  $this->nomConcours;
    }

      /**
      * @ORM\PostUpdate()
    */
    public function PostPersist(){
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
     * Get nombrePlace
     *
     * @return int
     */
    public function getNombrePlace()
    {
        return $this->nombrePlace;
    }

        /**
     * Get shouldAlert
     *
     * @return boolean
     */
    public function getShouldAlert()
    {
        return $this->shouldAlert;
    }
    /**
     * Set nombreInscrit
     *
     * @param integer $nombreInscrit
     *
     * @return Session
     */
    public function setShouldAlert($shouldAlert)
    {
        $this->shouldAlert = $shouldAlert;

        return $this;
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
        if($this->abreviation==null)
             return $this->concours->getAbreviation();
        return $this->abreviation;
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
    return  $this->nomConcours;
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
         if($this->serie==null)
              $this->concours->getSerie();
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
        if($this->niveau==null)
              $this->concours->getNiveau();
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
        if($this->dateMax==null)
        $this->concours->getDateMax();
        return $this->dateMax;
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
        $lien->setProgramme( $this);
        $this->liens[] = $lien;
        return $this;
    }

    /**
     * Remove lien
     *
     * @param \AppBundle\Entity\Objectif $lien
     */
    public function removePartie(\AppBundle\Entity\Partie $lien)
    {
        $this->parties->removeElement($lien);
    }


     /**
     * Add lien
     *
     * @param \AppBundle\Entity\Objectif $lien
     *
     * @return Programme
     */
    public function addPartie(\AppBundle\Entity\Partie $lien)
    {
       
        $this->parties[] = $lien;
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


    /**
     * Set groupe
     *
     * @param \Pwm\AdminBundle\Entity\Groupe $groupe
     *
     * @return Notification
     */
    public function setGroupe(\Pwm\AdminBundle\Entity\Groupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \Pwm\AdminBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }   



    /**
     * Set discussionName
     *
     * @param string $discussionName
     *
     * @return Session
     */
    public function setDiscussionName($discussionName)
    {
        $this->discussionName = $discussionName;

        return $this;
    }

    /**
     * Get discussionName
     *
     * @return string
     */
    public function getDiscussionName()
    {
        return $this->discussionName;
    }

    /**
     * Set owner
     *
     * @param \Pwm\AdminBundle\Entity\Info $owner
     *
     * @return Session
     */
    public function setOwner($owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Pwm\AdminBundle\Entity\Info
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add party
     *
     * @param \AppBundle\Entity\Partie $party
     *
     * @return Session
     */
    public function addParty(\AppBundle\Entity\Partie $party)
    {
        $this->parties[] = $party;

        return $this;
    }

    /**
     * Remove party
     *
     * @param \AppBundle\Entity\Partie $party
     */
    public function removeParty(\AppBundle\Entity\Partie $party)
    {
        $this->parties->removeElement($party);
    }

    /**
     * Get parties
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParties()
    {
        return $this->parties;
    }

    /**
     * Set newressource
     *
     * @param boolean $newressource
     *
     * @return Session
     */
    public function setNewressource($newressource)
    {
        $this->newressource = $newressource;

        return $this;
    }

    /**
     * Get newressource
     *
     * @return boolean
     */
    public function getNewressource()
    {
        return $this->newressource;
    }

    /**
     * Add ressource
     *
     * @param \Pwm\AdminBundle\Entity\Ressource $ressource
     *
     * @return Session
     */
    public function addRessource(\Pwm\AdminBundle\Entity\Ressource $ressource)
    {
        $this->ressources[] = $ressource;

        return $this;
    }

    /**
     * Remove ressource
     *
     * @param \Pwm\AdminBundle\Entity\Ressource $ressource
     */
    public function removeRessource(\Pwm\AdminBundle\Entity\Ressource $ressource)
    {
        $this->ressources->removeElement($ressource);
    }

    /**
     * Get ressources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRessources()
    {
        return $this->ressources;
    }

    /**
     * Set articleDescriptif
     *
     * @param \Pwm\MessagerBundle\Entity\Notification $articleDescriptif
     *
     * @return Concours
     */
    public function setArticleDescriptif(\Pwm\MessagerBundle\Entity\Notification $articleDescriptif = null)
    {
        $this->articleDescriptif = $articleDescriptif;

        return $this;
    }

    /**
     * Get articleDescriptif
     *
     * @return \Pwm\MessagerBundle\Entity\Notification
     */
    public function getArticleDescriptif()
    {
        return $this->articleDescriptif;
    }

}
