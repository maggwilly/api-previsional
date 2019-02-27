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
     * @ORM\Column(name="telephone", type="string", length=255)
     */
    private $telephone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
        /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $long;

            /**
     * @var string
     *
     * @ORM\Column(name="lat", type="string", length=255, nullable=true)
     */
    private $lat;

   /**
     * @var string
     * @ORM\Column(name="ville", type="string", length=255,nullable=true)
     */
    private $ville;

       /**
     * @var string
     * @ORM\Column(name="quartier", type="string", length=255,nullable=true)
     */
    private $quartier;


           /**
     * @var string
     * @ORM\Column(name="pays", type="string", length=255,nullable=true)
     */
    private $pays;


               /**
     * @var string
     * @ORM\Column(name="adresse", type="string", length=255,nullable=true)
     */
    private $adresse;
    /**

     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",inversedBy="pointVentes")
     * @var User
     */
    protected $user;
   /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Secteur" ,inversedBy="pointVentes")
     * @var User
     */
    protected $secteur;
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User",inversedBy="pointsPassages", cascade={"persist","remove"})
     * @var User
     */
    protected $agents;

       /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commende", mappedBy="user", cascade={"persist","remove"})
   */
    private $commendes;



        public function __construct(User $user=null)
    {
        $this->date=new \DateTime();
        $this->pays='Cameroun';
        $this->commendes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->agents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user=$user->getParent();
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
}
