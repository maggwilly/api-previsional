<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement_")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AbonnementRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Abonnement
{


    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime")
     */
    private $endDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     * @var string
     *
     * @ORM\Column(name="method", type="string", length=255)
     */
    private $method;



    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;


    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;


        /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User" ,inversedBy="abonnement")
     * @var User
     */
    protected $user;

        /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Price")
     * @var User
     */
    protected $price;


        /**
     * @var int
     *
     * @ORM\Column(name="nombreusers", type="integer")
     */
    private $nombreusers;
     /**
     * Constructor
     */
    public function __construct(\AppBundle\Entity\Price $price = null)
    {
          $this->date =new \DateTime(); 
           $this->startDate=new \DateTime();
          $this->price=$price; 
    }


     /**
    * @ORM\PrePersist()
    */
    public function PrePersist(){
          $this->endDate=new \DateTime();
          $this->endDate->modify('+'.$this->$price->getDuree().' month');
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
    }     /**
     * Set user
     *
     * @param \Pwm\AdminBundle\Entity\User $user
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
     * @return \Pwm\AdminBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Abonnement
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * Get endDate
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Abonnement
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }


    /**
     * Set method
     *
     * @param string $method
     * @return Abonnement
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return string 
     */
    public function getMethod()
    {
        return $this->method;
    }


    /**
     * Set plan
     *
     * @param string $plan
     * @return Abonnement
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return string 
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Abonnement
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Abonnement
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set nombreusers
     *
     * @param integer $nombreusers
     *
     * @return Price
     */
    public function setNombreusers($nombreusers)
    {
        $this->nombreusers = $nombreusers;

        return $this;
    }

    /**
     * Get nombreusers
     *
     * @return int
     */
    public function getNombreusers()
    {
        return $this->nombreusers;
    }
 
  
}
