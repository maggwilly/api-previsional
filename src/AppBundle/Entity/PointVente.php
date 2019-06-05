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
     * @ORM\Column(name="lat", type="string", length=120, nullable=true)
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
     * @ORM\Column(name="adresse", type="string", length=255,nullable=true)
     */
    private $adresse;
    /**

     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",inversedBy="pointVentes")
     */
    protected $user;
    
    /*
      * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    protected $createdBy;
   /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Secteur" ,inversedBy="pointVentes")
     * @var User
     */
    protected $secteur;
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User",inversedBy="pointsPassages", cascade={"persist"})
     * @var User
     */
    protected $agents;

    /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commende", mappedBy="user", cascade={"persist"})
   */
    private $commendes;
  
    private $lastLines;

    private $stored=true;
 /**
   *@ORM\OneToOne(
   targetEntity="AppBundle\Entity\Rendezvous", 
   inversedBy="pointVente", 
   orphanRemoval=true,
   cascade={"persist","remove"})
   */
    private $rendezvous;

    public function __construct(User $user=null)
    {
        $this->date=new \DateTime();
        $this->pays='Cameroun';
        $this->commendes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->agents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user=$user->getParent();
        $this->createdBy=$user;
        $this->secteur=$user->getSecteur();
        $this->addAgent($user);
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
    public function setId($id)
    {
        $this->id=$id;
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
     * Set nom
     *
     * @param string $nom
     *
     * @return PointVente
     */
    public function setLastLines($lastLines)
    {
        $this->lastLines = $lastLines;

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
    public function getType()
    {
        return $this->type;
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
     * Set rendezvous
     *
     * @param \AppBundle\Entity\Rendezvous $rendezvous
     *
     * @return PointVente
     */
    public function setRendezvous(\AppBundle\Entity\Rendezvous $rendezvous = null)
    {
        //if($this->rendezvous==null&&$rendezvous!=null)
           $this->rendezvous = $rendezvous;
        /*elseif (($rendezvous!=null)&&($this->rendezvous->getDateat()<=$rendezvous->getDateat())) {
            $this->rendezvous = $rendezvous->setCommentaire($this->rendezvous->getCommentaire());
        }*/
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
}
