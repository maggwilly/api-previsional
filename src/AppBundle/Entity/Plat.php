<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plat
 *
 * @ORM\Table(name="plat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlatRepository")
 */
class Plat
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateSave", type="date")
     */
    private $dateSave;
	
    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Menu",inversedBy="plats")
   * @ORM\JoinColumn(nullable=false)
   */
  
    private $menu;

	/**
   * @ORM\OneToOne(targetEntity="AppBundle\Entity\Image" , cascade={"persist","remove"})
   */
    private $image;

   /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commande", mappedBy="plat")
   */
    private $commandes;
    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="est_special", type="boolean", nullable=true)
     */
    private $estSpecial;

	 /**
     * @var bool
     *
     * @ORM\Column(name="est_fini", type="boolean", nullable=true)
     */
    private $estFini;


 /**
     * @var bool
     *
     * @ORM\Column(name="est_pret", type="boolean", nullable=true)
     */
    private $estPret;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


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
     * @return Plat
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
     * Set prix
     *
     * @param integer $prix
     * @return Plat
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Plat
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct($estSpecial=true,$estPret=true,$estFini=false)

    {
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->estSpecial=$estSpecial;
        $this->estPret=$estPret;
        $this->estFini=$estFini;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     * @return Plat
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
     * Add commandes
     *
     * @param \AppBundle\Entity\Commande $commandes
     * @return Plat
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
     * Set dateSave
     *
     * @param \DateTime $dateSave
     * @return Plat
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
     * Set estSpecial
     *
     * @param boolean $estSpecial
     * @return Plat
     */
    public function setEstSpecial($estSpecial)
    {
        $this->estSpecial = $estSpecial;

        return $this;
    }

    /**
     * Get estSpecial
     *
     * @return boolean 
     */
    public function getEstSpecial()
    {
        return $this->estSpecial;
    }

    /**
     * Set estFini
     *
     * @param boolean $estFini
     * @return Plat
     */
    public function setEstFini($estFini)
    {
        $this->estFini = $estFini;

        return $this;
    }

    /**
     * Get estFini
     *
     * @return boolean 
     */
    public function getEstFini()
    {
        return $this->estFini;
    }

    /**
     * Set estPret
     *
     * @param boolean $estPret
     * @return Plat
     */
    public function setEstPret($estPret)
    {
        $this->estPret = $estPret;

        return $this;
    }

    /**
     * Get estPret
     *
     * @return boolean 
     */
    public function getEstPret()
    {
        return $this->estPret;
    }

    /**
     * Set menu
     *
     * @param \AppBundle\Entity\Menu $menu
     * @return Plat
     */
    public function setMenu(\AppBundle\Entity\Menu $menu)
    {
        $this->menu = $menu;
        $this->dateSave = $menu->getDateSave();

        return $this;
    }

    /**
     * Get menu
     *
     * @return \AppBundle\Entity\Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
