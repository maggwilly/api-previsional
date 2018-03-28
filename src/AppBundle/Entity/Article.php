<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
* @ORM\HasLifecycleCallbacks
 */
class Article
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
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="validated", type="boolean", nullable=true)
     */
    private $validated;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text", nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="introduction", type="text")
     */
    private $introduction;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

     /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Content", mappedBy="article", cascade={"persist","remove"})
   */
    private $contents;  

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   */
    private $user;

    /**
   * @ORM\OneToOne(targetEntity="AppBundle\Entity\Partie", mappedBy="article", cascade={"persist","remove"})
   */
    private $partie;

   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   */
    private $validateur;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date=new \DateTime();
    }

      /**
    * @ORM\PrePersist()
    */
    public function PrePersist(){
       $this->addContent(new Content( $this->introduction,'Introduction'));
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
     * @return Article
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
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setType($titre)
    {
        $this->titre = $type;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

   /**
     * Get titre
     *
     * @return string 
     */
    public function getwebLink()
    {
        return 'https://concours.centor.org/v1/article/'.$this->id.'/show/from/mobile'; //link to view on line
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     * @return Question
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean 
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set introduction
     *
     * @param string $introduction
     * @return Article
     */
    public function setIntroduction($introduction)
    {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * Get introduction
     *
     * @return string 
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Article
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
     * Add contents
     *
     * @param \AppBundle\Entity\Content $contents
     * @return Article
     */
    public function addContent(\AppBundle\Entity\Content $contents)
    {
        $contents->setArticle($this);
        $this->contents[] = $contents;
        return $this;
    }

    /**
     * Remove contents
     *
     * @param \AppBundle\Entity\Content $contents
     */
    public function removeContent(\AppBundle\Entity\Content $contents)
    {
        $this->contents->removeElement($contents);
    }

    /**
     * Get contents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Question
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }    

    /**
     * Set validateur
     *
     * @param \AppBundle\Entity\User $validateur
     * @return Article
     */
    public function setValidateur(\AppBundle\Entity\User $validateur = null)
    {
        $this->validateur = $validateur;

        return $this;
    }

    /**
     * Get validateur
     *
     * @return \AppBundle\Entity\User 
     */
    public function getValidateur()
    {
        return $this->validateur;
    }


    /**
     * Set partie
     *
     * @param \AppBundle\Entity\Partie $partie
     *
     * @return Article
     */
    public function setPartie(\AppBundle\Entity\Partie $partie = null)
    {
        $this->partie = $partie;

        return $this;
    }

    /**
     * Get partie
     *
     * @return \AppBundle\Entity\Partie
     */
    public function getPartie()
    {
        return $this->partie;
    }
}
