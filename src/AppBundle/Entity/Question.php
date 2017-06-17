<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 */
class Question
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
     * @ORM\Column(name="type",  type="string", length=255, nullable=true)
     */
    private $type;



     /**
     * @var string
     *
     * @ORM\Column(name="showLink", type="string", length=755, nullable=true)
     */
    private $showLink;

    /**
     * @var string
     *
     * @ORM\Column(name="math", type="text", nullable=true)
     */
    private $math;
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    
    private $image;


    /**
     * @var string
     *
     * @ORM\Column(name="validated", type="boolean", nullable=true)
     */
    private $validated;
    /**
     * @var string
     *
     * @ORM\Column(name="explication", type="text", nullable=true)
     */
    private $explication;


    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;
   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   */
    private $validateur;
   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partie" ,inversedBy="questions")
   */
    private $partie;


    /**
     * @var int
     *
     * @ORM\Column(name="question_time", type="integer")
     */
    private $time;

    /**
     * @var string
     *
     * @ORM\Column(name="rep", type="string", length=255)
     */
    private $rep;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer",  nullable=true)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="propA", type="text")
     */
    private $propA;

    /**
     * @var string
     *
     * @ORM\Column(name="propB", type="text")
     */
    private $propB;

    /**
     * @var string
     *
     * @ORM\Column(name="propC", type="text",  nullable=true)
     */
    private $propC;

    /**
     * @var string
     *
     * @ORM\Column(name="propD", type="text", nullable=true)
     */
    private $propD;

    /**
     * @var string
     *
     * @ORM\Column(name="propE", type="text",  nullable=true)
     */
    private $propE;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $imageEntity;


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
     * Constructor
     */
    public function __construct()
    {
        $this->date=new \DateTime();
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Question
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
     * Set math
     *
     * @param string $math
     * @return Question
     */
    public function setMath($math)
    {
        $this->math = $math;

        return $this;
    }

    /**
     * Get math
     *
     * @return string 
     */
    public function getMath()
    {
        return $this->math;
    }


    /**
     * Set image
     *
     * @param string $image
     * @return Question
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
        if($this->imageEntity!=null)
           return $this->image='https://entrances.herokuapp.com/'.$this->imageEntity->getWebPath();
       return $this->image;
    }

    /**
     * Set historique
     *
     * @param string $historique
     * @return Question
     */
    public function setShowLink($historique)
    {
        $this->showLink = $historique;

        return $this;
    }

    /**
     * Get historique
     *
     * @return string 
     */
    public function getShowLink()
    {
  if($this->showLink==null&&$this->id!=null)
        return $this->showLink ='https://entrances.herokuapp.com/v1/question/'.$this->id.'/show/from/mobile';// url defaul to view question;
    return $this->showLink;
    }

    /**
     * Set explication
     *
     * @param string $explication
     * @return Question
     */
    public function setExplication($explication)
    {
        $this->explication = $explication;

        return $this;
    }

    /**
     * Get explication
     *
     * @return string 
     */
    public function getExplication()
    {   
        if($this->explication!=null&&$this->partie!=null)
              return $this->explication=$this->partie->getCours();
   return $this->explication; // url to cours
    }

    /**
     * Set time
     *
     * @param integer $time
     * @return Question
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return integer 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set rep
     *
     * @param string $rep
     * @return Question
     */
    public function setRep($rep)
    {
        $this->rep = $rep;

        return $this;
    }

    /**
     * Get rep
     *
     * @return string 
     */
    public function getRep()
    {
        return $this->rep;
    }

    /**
     * Set note
     *
     * @param integer $note
     * @return Question
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
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
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set propA
     *
     * @param string $propA
     * @return Question
     */
    public function setPropA($propA)
    {
        $this->propA = $propA;

        return $this;
    }

    /**
     * Get propA
     *
     * @return string 
     */
    public function getPropA()
    {
        return $this->propA;
    }

    /**
     * Set propB
     *
     * @param string $propB
     * @return Question
     */
    public function setPropB($propB)
    {
        $this->propB = $propB;

        return $this;
    }

    /**
     * Get propB
     *
     * @return string 
     */
    public function getPropB()
    {
        return $this->propB;
    }

    /**
     * Set propC
     *
     * @param string $propC
     * @return Question
     */
    public function setPropC($propC)
    {
        $this->propC = $propC;

        return $this;
    }

    /**
     * Get propC
     *
     * @return string 
     */
    public function getPropC()
    {
        return $this->propC;
    }

    /**
     * Set propD
     *
     * @param string $propD
     * @return Question
     */
    public function setPropD($propD)
    {
        $this->propD = $propD;

        return $this;
    }

    /**
     * Get propD
     *
     * @return string 
     */
    public function getPropD()
    {
        return $this->propD;
    }

    /**
     * Set propE
     *
     * @param string $propE
     * @return Question
     */
    public function setPropE($propE)
    {
        $this->propE = $propE;

        return $this;
    }

    /**
     * Get propE
     *
     * @return string 
     */
    public function getPropE()
    {
        return $this->propE;
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
     * Set partie
     *
     * @param \AppBundle\Entity\Partie $partie
     * @return Question
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



    /**
     * Set text
     *
     * @param string $text
     * @return Question
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set validateur
     *
     * @param \AppBundle\Entity\User $validateur
     * @return Question
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
     * Set image
     *
     * @param \PW\QCMBundle\Entity\Image $image
     * @return QCM
     */
    public function setImageEntity(\AppBundle\Entity\Image $image = null)
    {
        $this->imageEntity = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \PW\QCMBundle\Entity\Image 
     */
    public function getImageEntity()
    {
        return $this->imageEntity;
    }

}
