<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Concours
 *
 * @ORM\Table(name="concours")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgrammeRepository")
 */
class Programme
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
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

        /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Programme" )
   */
    private $auMoinsdeMemeQue;

    private $programme;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

   
     /** @var string
     *
     * @ORM\Column(name="abreviation", type="text", nullable=true)
     */
    private $abreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;
    
    /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Matiere", mappedBy="programme", cascade={"persist","remove"})
    * @ORM\OrderBy({ "id" = "ASC"})
   */
    private $matieres;


    /**
     * Constructor
     */
    public function __construct($nom=null)
    {
    $this->nom=$nom;
    $this->matieres = new \Doctrine\Common\Collections\ArrayCollection();
    $this->date=new \DateTime();
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
     * Set nom
     *
     * @param string $nom
     * @return Concours
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
        if(empty($this->matieres))
        return $this->nom;
        $nom=$this->nom.'* ';
        foreach ($this->matieres as $matiere) {
            $nom= $nom.$matiere->getTitre().':'.$matiere->getPoids().'%, ';
        }
         return $nom;
    }

    /**
     * Set ecole
     *
     * @param string $ecole
     * @return Concours
     */
    public function setAuMoinsdeMemeQue(\AppBundle\Entity\Programme $programme= null)
    {
        $this->auMoinsdeMemeQue = $programme;

        return $this;
    }

    /**
     * Get ecole
     *
     * @return string 
     */
    public function getAuMoinsdeMemeQue(){
    if($this->auMoinsdeMemeQue==$this)
            return null;
        return $this->auMoinsdeMemeQue;
    
    }


   

    /**
     * Set abreviation
     *
     * @param string $abreviation
     * @return Concours
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
        return $this->abreviation;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Concours
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
     * Add matieres
     *
     * @param \AppBundle\Entity\Matiere $matieres
     * @return Concours
     */
    public function addMatiere(\AppBundle\Entity\Matiere $matieres)
    {
        $this->matieres[] = $matieres;

        return $this;
    }

    /**
     * Remove matieres
     *
     * @param \AppBundle\Entity\Matiere $matieres
     */
    public function removeMatiere(\AppBundle\Entity\Matiere $matieres)
    {
        $this->matieres->removeElement($matieres);
    }

    /**
     * Get matieres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMatieres()
    { 
        if($this->auMoinsdeMemeQue==$this||$this->auMoinsdeMemeQue==null)
              return $this->matieres;
            return $this->auMoinsdeMemeQue->getMatieres();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getProgramme()
    {
        if($this->auMoinsdeMemeQue!=null &&$this->auMoinsdeMemeQue!=$this)
            return  $this->programme=$this->auMoinsdeMemeQue->getId();
        return $this->programme=$this->id;
    }

    
}
