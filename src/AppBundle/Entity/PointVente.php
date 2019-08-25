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
     * @var string
     *
     * @ORM\Column(name="id", type="string", unique=true)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=120)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=120)
     */
    private $telephone;

   /**
     * @var string
     * @ORM\Column(name="type", type="string", length=120, nullable=true)
     */
    private $type;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
        /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=120, nullable=true)
     */
    private $long;

            /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=120, nullable=true)
     */
    private $lat;

   /**
     * @var string
     * @ORM\Column(name="ville", type="string", length=120,nullable=true)
     */
    private $ville;

       /**
     * @var string
     * @ORM\Column(name="quartier", type="string", length=120,nullable=true)
     */
    private $quartier;

       /**
     * @var string
     * @ORM\Column(name="relativeTo", type="string", length=180,nullable=true)
     */
    private $relativeTo;

    
      /**
     * @var string
     * @ORM\Column(name="pays", type="string", length=120,nullable=true)
     */
    private $pays;

    /**
     * @var string
     * @ORM\Column(name="adresse", type="string", length=500,nullable=true)
     */
    private $adresse;

    /**
     * @var string
     * @ORM\Column(name="reference", type="string", length=300,nullable=true)
     */
    private $reference;
    /**

     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",inversedBy="pointVentes")
     */
    protected $user;
    
    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     **/
    protected $createdBy;
   /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Secteur" ,inversedBy="pointVentes", cascade={"persist"})
     * @var User
     */
    protected $secteur;
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User",inversedBy="pointsPassages", cascade={"persist"})
     * @var User
     */
    protected $agents;

    /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commende", mappedBy="pointVente", cascade={"persist"})
   */
    private $commendes;

    /**
     * @var \boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;
    /**
     * @var int
     *
     * @ORM\Column(name="week", type="integer", nullable=true)
     */
    private $week;

        /**
     * @var int
     *
     * @ORM\Column(name="week_text", type="string", length=255, nullable=true)
     */
    private $weekText;

 /**
   *@ORM\OneToMany(targetEntity="AppBundle\Entity\Rendezvous",  mappedBy="pointVente" , cascade={"persist"})
   */
    private $rendezvouss;
    /**
     * @var int
     *
     * @ORM\Column(name="month", type="string", length=255, nullable=true)
     */
    private $month;
    //last commende
    private $lastCommende;
    //commende's las lines
     private $lastLines;
     //the first commende also called engagement
    private $firstCommende;
    //is it stored in db
    private $stored=true;
    // 
    private $visited;

  // last redv
    private $rendezvous;

    public function __construct(User $user=null)
    {
        $this->date=new \DateTime();
        $this->pays='Cameroun';
        $this->commendes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->agents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rendezvouss = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user=$user->getParent();
        $this->createdBy=$user;
        $this->addAgent($user);
    }

    
/**
* @ORM\PrePersist()
*/
 public function doStuffOnPersist(){
    $this->week =$this->date->format("W");
    if($this->secteur==null&&$user->getSecteur()!=null)
        $this->secteur=$user->getSecteur();
      elseif ($this->secteur==null) 
         $this->secteur= new Secteur($user,$this->quartier);
  }
    
    /** 
    *@ORM\PostLoad()
     */
    public function doStuffOnPostLoad()
    {
     if ($this->secteur==null) 
         $this->secteur= new Secteur($user,$this->quartier);
    }
    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id=$id;
        return $this;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
    
    public function setEnabled($enabled)
    {
        $this->enabled=$enabled;
        return $this;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return PointVente
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }
    /**
     * Set week
     *
     * @param integer $week
     *
     * @return Commende
     */
    public function setLastCommende(\AppBundle\Entity\Commende $lastCommende = null)
    {
        $this->lastCommende = $lastCommende;

        return $this;
    }

    /**
     * Get week
     *
     * @return integer
     */
    public function getLastCommende()
    {
        return $this->lastCommende;
    }

    /**
     * Set week
     *
     * @param integer $firstCommende
     *
     * @return Commende
     */
    public function setFirstCommende(\AppBundle\Entity\Commende $firstCommende = null)
    {
        $this->firstCommende = $firstCommende;

        return $this;
    }

    /**
     * Get firstCommende
     *
     * @return integer
     */
    public function getLFirstCommende()
    {
        return $this->firstCommende;
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
     *
     * @return PointVente
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }
    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Commende
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
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set long
     *
     * @param string $long
     *
     * @return PointVente
     */
    public function setLong($long)
    {
        $this->long = $long;

        return $this;
    }

    /**
     * Get long
     *
     * @return string
     */
    public function getLong()
    {
        return $this->long;
    }

    /**
     * Set lat
     *
     * @param string $lat
     *
     * @return PointVente
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Add agent
     *
     * @param \AppBundle\Entity\User $agent
     *
     * @return PointVente
     */
    public function addAgent(\AppBundle\Entity\User $agent)
    {
        $this->agents[] = $agent;

        return $this;
    }

    /**
     * Remove agent
     *
     * @param \AppBundle\Entity\User $agent
     */
    public function removeAgent(\AppBundle\Entity\User $agent)
    {
        $this->agents->removeElement($agent);
    }

    /**
     * Get agents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAgents()
    {
        return $this->agents;
    }

    /**
     * Add commende
     *
     * @param \AppBundle\Entity\Commende $commende
     *
     * @return PointVente
     */
    public function addCommende(\AppBundle\Entity\Commende $commende)
    {
        $this->commendes[] = $commende;

        return $this;
    }

    /**
     * Remove commende
     *
     * @param \AppBundle\Entity\Commende $commende
     */
    public function removeCommende(\AppBundle\Entity\Commende $commende)
    {
        $this->commendes->removeElement($commende);
    }

    /**
     * Get commendes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommendes()
    {
        return $this->commendes;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return PointVente
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
     * Set ville
     *
     * @param string $ville
     *
     * @return PointVente
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set quartier
     *
     * @param string $quartier
     *
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
     * Set pays
     *
     * @param string $pays
     *
     * @return PointVente
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
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
     * Set secteur
     *
     * @param \AppBundle\Entity\Secteur $secteur
     *
     * @return PointVente
     */
    public function setSecteur(\AppBundle\Entity\Secteur $secteur = null)
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * Get secteur
     *
     * @return \AppBundle\Entity\Secteur
     */
    public function getSecteur()
    {
     return $this->secteur;
    }
    /**
     * Set type
     *
     * @param string $type
     *
     * @return User
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
    public function getStored()
    {
        return $this->stored;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return User
     */
    public function setStored($stored)
    {
        $this->stored = $stored;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getVisited()
    {
        return $this->visited;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return User
     */
    public function setVisited($visited)
    {
        $this->visited = $visited;

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
     * Set rendezvous
     *
     * @param \AppBundle\Entity\Rendezvous $rendezvous
     *
     * @return PointVente
     */
    public function setRendezvous(\AppBundle\Entity\Rendezvous $rendezvous = null)
    {
           $this->rendezvous = $rendezvous;

        return $this;
    }

    /**
     * Get rendezvous
     *
     * @return \AppBundle\Entity\Rendezvous
     */
    public function getRendezvous()
    {
        return $this->rendezvous;
    }

    /**
     * Set relativeTo
     *
     * @param string $relativeTo
     *
     * @return PointVente
     */
    public function setRelativeTo($relativeTo)
    {
        $this->relativeTo = $relativeTo;

        return $this;
    }

    /**
     * Get relativeTo
     *
     * @return string
     */
    public function getRelativeTo()
    {
        return $this->relativeTo;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return PointVente
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Get week
     *
     * @return integer
     */
    public function getWeek()
    {  /*if($this->week)
        return $this->week;*/
      return $this->date->format("W");  
    }


    /**
     * Set weekText
     *
     * @param string $weekText
     *
     * @return Commende
     */
    public function setWeekText($weekText)
    {
        $this->weekText = $weekText;

        return $this;
    }

    /**
     * Get weekText
     *
     * @return string
     */
    public function getWeekText()
    {
        return $this->weekText;
    }

    /**
     * Set month
     *
     * @param integer $month
     *
     * @return Commende
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set week
     *
     * @param integer $week
     *
     * @return PointVente
     */
    public function setWeek($week)
    {
        $this->week = $week;

        return $this;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return PointVente
     */
    public function setCreatedBy(\AppBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Add rendezvouss
     *
     * @param \AppBundle\Entity\Rendezvous $rendezvouss
     *
     * @return PointVente
     */
    public function addRendezvouss(\AppBundle\Entity\Rendezvous $rendezvouss)
    {
        $rendezvouss->setPointVente($this);
        $this->rendezvouss[] = $rendezvouss;

        return $this;
    }

    /**
     * Remove rendezvouss
     *
     * @param \AppBundle\Entity\Rendezvous $rendezvouss
     */
    public function removeRendezvouss(\AppBundle\Entity\Rendezvous $rendezvouss)
    {
        $this->rendezvouss->removeElement($rendezvouss);
    }

    /**
     * Get rendezvouss
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRendezvouss()
    {
        return $this->rendezvouss;
    }
}
