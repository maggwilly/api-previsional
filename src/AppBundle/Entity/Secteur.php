<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secteur
 *
 * @ORM\Table(name="secteur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SecteurRepository")
 */
class Secteur
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @var User
     */
    protected $user;
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

        
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
     *
     * @ORM\Column(name="radius", type="integer", nullable=true)
     */
     private $radius;

   /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\PointVente", mappedBy="secteur", cascade={"persist","remove"})
   */
    private $pointVentes;

     private $stored=true;
    /**
     * Constructor
     */
    public function __construct(User $user=null,$nom=null)
    {   $this->nom=$nom;
        $this->date =new \DateTime(); 
        if($this->user)
         $this->user=$user->getParent();
        $this->pointVentes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param string $id
     *
     * @return Secteur
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Secteur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
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
     * Set description
     *
     * @param string $description
     *
     * @return Secteur
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
     * Set ville
     *
     * @param string $ville
     *
     * @return Secteur
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
     * Add pointVente
     *
     * @param \AppBundle\Entity\PointVente $pointVente
     *
     * @return Secteur
     */
    public function addPointVente(\AppBundle\Entity\PointVente $pointVente)
    {
        $this->pointVentes[] = $pointVente;

        return $this;
    }

    /**
     * Remove pointVente
     *
     * @param \AppBundle\Entity\PointVente $pointVente
     */
    public function removePointVente(\AppBundle\Entity\PointVente $pointVente)
    {
        $this->pointVentes->removeElement($pointVente);
    }

    /**
     * Get pointVentes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPointVentes()
    {
        return $this->pointVentes;
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return PointVente
     */
    public function setRadius($date)
    {
        $this->radius = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getRadius()
    {
        return $this->radius;
    }
}
