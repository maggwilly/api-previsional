<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matiere
 *
 * @ORM\Table(name="matiere")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MatiereRepository")
 */
class Matiere
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
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Matiere" )
   */
    private $auMoinsdeMemeQue;

    private $contenu;
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

        /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="otherRessourcesLink", type="string", length=755, nullable=true)
     */
    private $otherRessourcesLink;


      /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=755, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="poids", type="integer", nullable=true)
     */
    private $poids;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=true)
     */
    private $categorie;


   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Programme" ,inversedBy="matieres")
   */
    private $programme;

    /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Partie", mappedBy="matiere", cascade={"persist","remove"})
   * @ORM\OrderBy({ "id" = "ASC"})
   */
    private $parties;


    /**
   * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Partie", cascade={"persist","remove"})
   * @ORM\OrderBy({ "index" = "ASC"})
   */
    private $unites;


     /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Objectif", mappedBy="matiere", cascade={"persist","remove"})
   */
    private $objectifs;

        /**
   * @ORM\ManyToMany(targetEntity="Pwm\AdminBundle\Entity\Ressource",  mappedBy="matieres", cascade={"persist"})
   */
    private $ressources; 

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parties = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objectifs = new \Doctrine\Common\Collections\ArrayCollection();
         $this->ressources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unites = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date=new \DateTime();
    }


    /**
     * Set ecole
     *
     * @param string $ecole
     * @return Concours
     */
    public function setAuMoinsdeMemeQue(\AppBundle\Entity\Matiere $programme= null)
    {
        $this->auMoinsdeMemeQue = $programme;

        return $this;
    }

    /**
     * Get ecole
     *
     * @return string 
     */
    public function getAuMoinsdeMemeQue()
    {
       if($this->auMoinsdeMemeQue==$this)
            return null;
        return $this->auMoinsdeMemeQue;
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
     * Set titre
     *
     * @param string $titre
     * @return Matiere
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }
        /**
     * Get titre
     *
     * @return string 
     */
    public function getDisplayName()
    {
        return $this->programme->getTitre().' > '.$this->titre;
    }
    /**
     * Set description
     *
     * @param string $description
     * @return Matiere
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
     * Set description
     * @param string $description
     * @return Matiere
     */
    public function setOtherRessourcesLink($description)
    {
        $this->otherRessourcesLink = $description;

        return $this;
    }


    /**
     * Get description
     *
     * @return string 
     */
    public function getOtherRessourcesLink()
    {
         if($this->otherRessourcesLink==null&&$this->id!=null)
    
        return $this->otherRessourcesLink='https://entrances.herokuapp.com/v1/matiere/'.$this->id.'/show/from/mobile'; //url to view list off objectif
              return $this->otherRessourcesLink;
    }

    /**
     * Set poids
     *
     * @param integer $poids
     * @return Matiere
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;

        return $this;
    }

    /**
     * Get poids
     *
     * @return integer 
     */
    public function getPoids()
    {
        return $this->poids;
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
     * Set categorie
     *
     * @param string $categorie
     * @return Matiere
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set concours
     *
     * @param \AppBundle\Entity\Programme $concours
     * @return Matiere
     */
    public function setProgramme(\AppBundle\Entity\Programme $concours = null)
    {
        $this->programme = $concours;

        return $this;
    }

    /**
     * Get concours
     *
     * @return \AppBundle\Entity\Programme 
     */
    public function getProgramme()
    {
        return $this->programme;
    }

    /**
     * Add parties
     *
     * @param \AppBundle\Entity\Partie $parties
     * @return Matiere
     */
    public function addParty(\AppBundle\Entity\Partie $parties)
    {
       
        $this->parties[] = $parties;

        return $this;
    }

    /**
     * Remove parties
     *
     * @param \AppBundle\Entity\Partie $parties
     */
    public function removeParty(\AppBundle\Entity\Partie $parties)
    {
        $this->parties->removeElement($parties);
    }

    /**
     * Get parties
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParties()
    {
        if($this->auMoinsdeMemeQue==$this||$this->auMoinsdeMemeQue==null)
              return $this->parties;
            return $this->auMoinsdeMemeQue->getParties();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getContenu()
    {
        if($this->auMoinsdeMemeQue!=null&&$this->auMoinsdeMemeQue!=$this)
            return  $this->contenu=$this->auMoinsdeMemeQue->getId();
        return $this->contenu= $this->id;
    }
    /**
     * Add objectifs
     *
     * @param \AppBundle\Entity\Objectif $objectifs
     * @return Partie
     */
    public function addObjectif(\AppBundle\Entity\Objectif $objectifs)
    {
        $this->objectifs[] = $objectifs;

        return $this;
    }

        /**
     * Remove objectifs
     *
     * @param \AppBundle\Entity\Objectif $objectifs
     */
    public function removeObjectif(\AppBundle\Entity\Objectif $objectifs)
    {
        $this->objectifs->removeElement($objectifs);
    }

    /**
     * Get objectifs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjectifs()
    {
        return $this->objectifs;
    }


    /**
     * Add unite
     *
     * @param \AppBundle\Entity\Partie $unite
     *
     * @return Matiere
     */
    public function addUnite(\AppBundle\Entity\Partie $unite)
    {
        $this->unites[] = $unite;

        return $this;
    }

    /**
     * Remove unite
     *
     * @param \AppBundle\Entity\Partie $unite
     */
    public function removeUnite(\AppBundle\Entity\Partie $unite)
    {
        $this->unites->removeElement($unite);
    }

    /**
     * Get unites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnites()
    {
        return $this->unites;
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
}
