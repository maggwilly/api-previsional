<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * /**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientRepository")
 */
class Client extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
   /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commande", mappedBy="client")
   *
   */
   private $commandes;

   /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commande", mappedBy="user")
   *
   */
   private $commandePrises;
   
   /**
   * @ORM\OneToOne(targetEntity="AppBundle\Entity\Image", cascade={"persist","remove"})
   */
   private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255,nullable=true)
     */
    private $nom;



    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;



    /**
     * @var string
     *
     * @ORM\Column(name="latLocal", type="string", length=255 ,nullable=true)
     */
    private $latLocal;

    /**
     * @var string
     *
     * @ORM\Column(name="longLocal", type="string", length=255, nullable=true)
     */
    private $longLocal;

    /**
     * @var bool
     *
     * @ORM\Column(name="piment", type="boolean",nullable=true,nullable=true)
     */
    private $piment;
	
	
    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255, nullable=true)
     */
    private $place;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSave", type="date",nullable=true)
     */
    private $dateSave;


     /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    protected $username;

     /**
     * @var string
     *
     * @ORM\Column(name="usernameCanonical", type="string", length=180, unique=true, nullable=false)
     */
    protected $usernameCanonical;

   /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=180)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="emailCanonical", type="string", length=180, unique=true)
     */
    protected $emailCanonical;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean",nullable=true)
     */
    protected $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string")
     */
    protected $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string")
     */
    protected $password;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    protected $plainPassword;

   /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastLogin", type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmationToken", type="string", length=180,unique=true ,nullable=true)
     */
    protected $confirmationToken;

   /**
     * @var \DateTime
     *
     * @ORM\Column(name="passwordRequestedAt", type="datetime" , nullable=true)
     */
    protected $passwordRequestedAt;


    /**
     * @var bool
     *
     * @ORM\Column(name="locked", type="boolean",nullable=true)
     */
    protected $locked;

    /**
     * @var bool
     *
     * @ORM\Column(name="expired", type="boolean",nullable=true)
     */
    protected $expired;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiresAt", type="datetime",nullable=true)
     */
    protected $expiresAt;

   
     /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    protected $roles;

     /**
     * @var bool
     *
     * @ORM\Column(name="credentialsExpired", type="boolean",nullable=true)
     */
    protected $credentialsExpired;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="credentialsExpireAt", type="datetime",nullable=true)
     */
    protected $credentialsExpireAt;

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
     * @return Client
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
     * Set adresse
     *
     * @param string $adresse
     * @return Client
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
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set latLocal
     *
     * @param string $latLocal
     * @return Client
     */
    public function setLatLocal($latLocal)
    {
        $this->latLocal = $latLocal;

        return $this;
    }

    /**
     * Get latLocal
     *
     * @return string 
     */
    public function getLatLocal()
    {
        return $this->latLocal;
    }

    /**
     * Set longLocal
     *
     * @param string $longLocal
     * @return Client
     */
    public function setLongLocal($longLocal)
    {
        $this->longLocal = $longLocal;

        return $this;
    }

    /**
     * Get longLocal
     *
     * @return string 
     */
    public function getLongLocal()
    {
        return $this->longLocal;
    }

    /**
     * Set piment
     *
     * @param boolean $piment
     * @return Client
     */
    public function setPiment($piment)
    {
        $this->piment = $piment;

        return $this;
    }

    /**
     * Get piment
     *
     * @return boolean 
     */
    public function isPiment()
    {
        return $this->piment;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return Client
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }
	

  
    /**
     * Constructor
     */
 
 public function __construct()
    {
        parent::__construct();
        // your own logic
    }

 

    public function __toString()
    {
        return $this->getUsername();
    }
    /**
     * Add commandes
     *
     * @param \AppBundle\Entity\Commande $commandes
     * @return Client
     */
    public function addCommande(\AppBundle\Entity\Commande $commandes)
    {
        $this->commandes[] = $commandes;

        return $this;
    }

    /**
     * Remove commandes
     *
     * @param \AppBundle\Entity\Commande $commandes
     */
    public function removeCommande(\AppBundle\Entity\Commande $commandes)
    {
        $this->commandes->removeElement($commandes);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     * @return Client
     */
    public function setImage(\AppBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image 
     */
    public function getImage()
    {
        if(is_null($this->image))
            return new Image();
        return $this->image;
    }



    /**
     * Get piment
     *
     * @return boolean 
     */
    public function getPiment()
    {
        return $this->piment;
    }

    /**
     * Add commandePrises
     *
     * @param \AppBundle\Entity\Commande $commandePrises
     * @return Client
     */
    public function addCommandePrise(\AppBundle\Entity\Commande $commandePrises)
    {
        $this->commandePrises[] = $commandePrises;

        return $this;
    }

    /**
     * Remove commandePrises
     *
     * @param \AppBundle\Entity\Commande $commandePrises
     */
    public function removeCommandePrise(\AppBundle\Entity\Commande $commandePrises)
    {
        $this->commandePrises->removeElement($commandePrises);
    }

    /**
     * Get commandePrises
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommandePrises()
    {
        return $this->commandePrises;
    }



    /**
     * Set dateSave
     *
     * @param \DateTime $dateSave
     * @return Client
     */
    public function setDateSave($dateSave)
    {
        $this->dateSave = $dateSave;

        return $this;
    }

    /**
     * Get dateSave
     *
     * @return \DateTime 
     */
    public function getDateSave()
    {
        return $this->dateSave;
    }


    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Client
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean 
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Get expired
     *
     * @return boolean 
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Get expiresAt
     *
     * @return \DateTime 
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Get credentialsExpired
     *
     * @return boolean 
     */
    public function getCredentialsExpired()
    {
        return $this->credentialsExpired;
    }

    /**
     * Get credentialsExpireAt
     *
     * @return \DateTime 
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }
}
