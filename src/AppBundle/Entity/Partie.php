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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="prerequis", type="text")
     */
    private $prerequis;


   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Matiere",inversedBy="parties")
   */
    private $matiere;

            /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Objectif", mappedBy="partie", cascade={"persist","remove"})
   */
    private $objectifs;

            /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Question", mappedBy="partie", cascade={"persist","remove"})
   */
    private $questions;    
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
    public function getTitre()
    {
        return $this->titre;
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
        return $this->prerequis;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->objectifs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
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
        return $this->questions;
    }
}
