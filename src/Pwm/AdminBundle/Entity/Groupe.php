<?php

namespace Pwm\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groupe
 *
 * @ORM\Table(name="desc_groupe")
 * @ORM\Entity(repositoryClass="Pwm\AdminBundle\Repository\GroupeRepository")
 */
class Groupe
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Session", inversedBy="groupe")
   */
    private $session;


        /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=255, options={"default" : "groupe"})
     */
    private $tag; 

    /**
     * Constructor
     */
    public function __construct($nom, \AppBundle\Entity\Session $session = null,$tag='public')
    {
        $this->date =new \DateTime();
        $this->nom =$nom;
        $this->session =$session;
        $this->tag =$tag;
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
     * @return Groupe
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Groupe
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
     * Set session
     *
     * @param \AppBundle\Entity\Session $session
     *
     * @return Notification
     */
    public function setSession(\AppBundle\Entity\Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return \AppBundle\Entity\Session
     */
    public function getSession()
    {
        return $this->session;
    } 

    

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Notification
     */
    public function setTag($titre)
    {
        $this->tag = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }     
}

