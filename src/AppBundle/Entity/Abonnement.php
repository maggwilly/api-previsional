<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement")
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
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="plan", type="string", length=255)
     */
    private $plan;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;


      /**
     * @var string
     *
     * @ORM\Column(name="studentId", type="string", length=255, nullable=true)
     */
    private $studentId;

    /**
     * @var string
     *
     * @ORM\Column(name="tel_paid_number", type="string", length=255, nullable=true)
     */
    private $tel_paid_number;


     /**
     * @var string
     *
     * @ORM\Column(name="uid", type="string", length=255)
     */
    private $uid;


  /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Programme" ,inversedBy="matieres")
   */
    private $programme;


     /**
     * Constructor
     */
    public function __construct($studentId=null)
    {
        $this->uid =$studentId;
         $this->date=new \DateTime();
    }


     /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function PrePersist(){
          $this->endDate=new \DateTime();
           $this->startDate=new \DateTime();
         if ($this->plan=='free') {
              $this->endDate->modify('+10 day');
         }elseif ($this->plan=='full') {
            // $this->endDate->modify('+91 day');
             $this->endDate->modify('+10 day');
         }if($this->user!=null)
         $this->method='espece';
    $this->status='confirmed';
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
     * Set studentId
     *
     * @param string $studentId
     * @return Abonnement
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;

        return $this;
    }

    /**
     * Get studentId
     *
     * @return string 
     */
    public function getStudentId()
    {
        return $this->studentId;
    }


    /**
     * Set uid
     *
     * @param string $uid
     *
     * @return Abonnement
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set telPaidNumber
     *
     * @param string $telPaidNumber
     *
     * @return Abonnement
     */
    public function setTelPaidNumber($telPaidNumber)
    {
        $this->tel_paid_number = $telPaidNumber;

        return $this;
    }

    /**
     * Get telPaidNumber
     *
     * @return string
     */
    public function getTelPaidNumber()
    {
        return $this->tel_paid_number;
    }
}
