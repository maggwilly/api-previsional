<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Objectif
 *
 * @ORM\Table(name="objectif")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObjectifRepository")
 */
class Objectif
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Matiere" ,inversedBy="objectifs")
   */
    private $matiere;

    /**
   * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Session",inversedBy="liens", cascade={"persist","remove"})*/
    private $sessions;


   /**
     * Set partie
     *
     * @param \AppBundle\Entity\Partie $partie
     * @return Objectif
     */
    public function setMatiere(\AppBundle\Entity\Matiere $partie = null)
    {
        $this->matiere = $partie;

        return $this;
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
     * @return Objectif
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
     * Set description
     *
     * @param string $description
     * @return Objectif
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
     * Get partie
     *
     * @return \AppBundle\Entity\Partie 
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

        /**
     * Set concours
     *
     * @param \AppBundle\Entity\Programme $concours
     * @return Matiere
     */
    public function setProgramme(\AppBundle\Entity\Session $concours = null)
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
     * Add session
     *
     * @param \AppBundle\Entity\Session $session
     *
     * @return Partie
     */
    public function addSession(\AppBundle\Entity\Session $session)
    {
        $this->sessions[] = $session;
        return $this;
    }

    /**
     * Remove session
     *
     * @param \AppBundle\Entity\Session $session
     */
    public function removeSession(\AppBundle\Entity\Session $session)
    {
        $this->sessions->removeElement($session);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSessions()
    {
        return $this->sessions;
    }    
}
