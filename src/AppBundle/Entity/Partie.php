<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partie
 *
 * @ORM\Table(name="partie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartieRepository")
 */
class Partie
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
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partie" )
   */
    private $auMoinsdeMemeQue;

    private $qcm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="cours", type="string", length=255,nullable=true)
     */
    private $cours;

    /**
     * @var string
     *
     * @ORM\Column(name="prerequis", type="text",nullable=true)
     */
    private $prerequis;

    /**
     * @var string
     *
     * @ORM\Column(name="objectif", type="text",nullable=true)
     */
    private $objectif;


   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Matiere",inversedBy="parties")
   */
    private $matiere;

            /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Question", mappedBy="partie", cascade={"persist","remove"})
   */
    private $questions; 

   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Article")
   */
    private $article;

       /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
         $this->date=new \DateTime();
    } 

    /**
     * Set ecole
     *
     * @param string $ecole
     * @return Concours
     */
    public function setAuMoinsdeMemeQue(\AppBundle\Entity\Partie $programme= null)
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
    {    if($this->auMoinsdeMemeQue==$this)
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
     * @return Partie
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
    public function getCours()
    {
        if($this->article!=null)
         return $this->article->getwebLink();
        return $this->cours;//

    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Partie
     */
    public function setCours($titre)
    {
        $this->cours = $titre;

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
        return $this->titre.' > '.$this->matiere->getTitre().' > '.$this->matiere->getProgramme()->getAbreviation();
    }
    /**
     * Set prerequis
     *
     * @param string $prerequis
     * @return Partie
     */
    public function setPrerequis($prerequis)
    {
        $this->prerequis = $prerequis;

        return $this;
    }

    /**
     * Get prerequis
     *
     * @return string 
     */
    public function getPrerequis()
    { 
        if($this->prerequis!=null)
          return $this->prerequis;
      return 'Avoir Maitrisé le programme de : .'.$this->matiere->getTitre().' du niveau requis pour ce concours';
    }
 

    /**
     * Set matiere
     *
     * @param \AppBundle\Entity\Matiere $matiere
     * @return Partie
     */
    public function setMatiere(\AppBundle\Entity\Matiere $matiere = null)
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return \AppBundle\Entity\Matiere 
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * Set matiere
     *
     * @param \AppBundle\Entity\Article $matiere
     * @return Partie
     */
    public function setArticle(\AppBundle\Entity\Article $matiere = null)
    {
        $this->article = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return \AppBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Remove objectifs
     *
     * @param \AppBundle\Entity\Objectif $objectifs
     */
    public function setObjectif($objectifs)
    {
        $this->objectif=$objectifs;
    }

    /**
     * Get objectifs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjectif()
    {
        if($this->objectif!=null)
          return $this->objectif;
      return 'Evaluer les aquis sur cette partie';
    }

    /**
     * Add questions
     *
     * @param \AppBundle\Entity\Question $questions
     * @return Partie
     */
    public function addQuestion(\AppBundle\Entity\Question $questions)
    {
        $this->questions[] = $questions;

        return $this;
    }


    /**
     * Remove questions
     *
     * @param \AppBundle\Entity\Question $questions
     */
    public function removeQuestion(\AppBundle\Entity\Question $questions)
    {
        $this->questions->removeElement($questions);
    }


    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestions()
    {  
        if($this->auMoinsdeMemeQue!=null&&$this->auMoinsdeMemeQue!=$this)
             return $this->auMoinsdeMemeQue->getQuestions();
        return $this->questions;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getQcm()
    {
        if($this->auMoinsdeMemeQue!=null&&$this->auMoinsdeMemeQue!=$this)
            return $this->qcm= $this->auMoinsdeMemeQue->getId();
        return $this->qcm=$this->id;
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
}
