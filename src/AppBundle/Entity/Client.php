<?php

namespace AppBundle\Entity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientRepository")
 */
class Client implements AdvancedUserInterface
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=false, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

  /**

   * @ORM\Column(name="roles", type="array")

   */

    private $roles = array();
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

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
     * @ORM\Column(name="piment", type="boolean",nullable=true)
     */
    private $piment;
	
	 /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean",nullable=true)
     */
    private $enabled;

 /**
     * @var bool
     *
     * @ORM\Column(name="accountNonExpired", type="boolean",nullable=true)
     */
    private $accountNonExpired;
     /**
     * @var bool
     *
     * @ORM\Column(name="credentialsNonExpired", type="boolean",nullable=true)
     */
    private $credentialsNonExpired;
     /**
     * @var bool
     *
     * @ORM\Column(name="accountNonLocked", type="boolean",nullable=true)
     */
    private $accountNonLocked;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255, nullable=true)
     */
    private $place;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSave", type="date")
     */
    private $dateSave;

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
     * Set password
     *
     * @param string $password
     * @return Client
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
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
	
	// Les getters et setters


  public function eraseCredentials()

  {

  }

    /**
     * Set username
     *
     * @param string $username
     * @return Client
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    
    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
       
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return Client
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array 
     */
    public function getRoles()
    {
        return $this->roles;
    }
    /**
     * Constructor
     */
 

 public function __construct( array $roles = array(), $enabled = true, $userNonExpired = true, $credentialsNonExpired = true, $userNonLocked = true)
    {   
        $this->enabled = $enabled;
        $this->accountNonExpired = $userNonExpired;
        $this->credentialsNonExpired = $credentialsNonExpired;
        $this->accountNonLocked = $userNonLocked;
        $this->roles = $roles;
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
     * Set enabled
     *
     * @param boolean $enabled
     * @return Client
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function isEnabled()
    {
        return $this->enabled;
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
     * Set accountNonExpired
     *
     * @param boolean $accountNonExpired
     * @return Client
     */
    public function setAccountNonExpired($accountNonExpired)
    {
        $this->accountNonExpired = $accountNonExpired;

        return $this;
    }

    /**
     * Get accountNonExpired
     *
     * @return boolean 
     */
    public function isAccountNonExpired()
    {
        return $this->accountNonExpired;
    }

    /**
     * Set credentialsNonExpired
     *
     * @param boolean $credentialsNonExpired
     * @return Client
     */
    public function setCredentialsNonExpired($credentialsNonExpired)
    {
        $this->credentialsNonExpired = $credentialsNonExpired;

        return $this;
    }

    /**
     * Get credentialsNonExpired
     *
     * @return boolean 
     */
    public function isCredentialsNonExpired()
    {
        return $this->credentialsNonExpired;
    }

    /**
     * Set accountNonLocked
     *
     * @param boolean $accountNonLocked
     * @return Client
     */
    public function setAccountNonLocked($accountNonLocked)
    {
        $this->accountNonLocked = $accountNonLocked;

        return $this;
    }

    /**
     * Get accountNonLocked
     *
     * @return boolean 
     */
    public function isAccountNonLocked()
    {
        return $this->accountNonLocked;
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
     * Get accountNonExpired
     *
     * @return boolean 
     */
    public function getAccountNonExpired()
    {
        return $this->accountNonExpired;
    }

    /**
     * Get credentialsNonExpired
     *
     * @return boolean 
     */
    public function getCredentialsNonExpired()
    {
        return $this->credentialsNonExpired;
    }

    /**
     * Get accountNonLocked
     *
     * @return boolean 
     */
    public function getAccountNonLocked()
    {
        return $this->accountNonLocked;
    }
}
