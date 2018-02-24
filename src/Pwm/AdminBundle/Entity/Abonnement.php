<?php

namespace Pwm\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement_")
 * @ORM\Entity(repositoryClass="Pwm\AdminBundle\Repository\AbonnementRepository")
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
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
     private $email;


    /**
   * @ORM\ManyToOne(targetEntity="Info" ,inversedBy="abonnements")
    * @ORM\JoinColumn(name="uid",referencedColumnName="uid" )
   */
    private $info;


  /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Session" ,inversedBy="abonnements")
   */
    private $session;



     /**
     * Constructor
     */
    public function __construct(\Pwm\AdminBundle\Entity\Commande $commande)
    {
       $this->status=$commande->getStatus();
        $this->plan=$commande->getPackage();
        $this->price=$commande->getAmount();
        $this->info=$commande->getInfo();
        $this->session=$commande->getSession();
      //  $this->commande=$commande;
        $this->method='OM';
        $this->date=new \DateTime();
    }


     /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function PrePersist(){
          $this->endDate=new \DateTime();
           $this->startDate=new \DateTime();
           switch ($this->plan) {
               case 'starter':
                 $this->endDate->modify('+'.$this->session->getPrice()->getStarterDelay().' day');
                   break;
               case 'standard':
                     $this->endDate->modify('+'.$this->session->getPrice()->getStandardDelay().' day');
                   break;               
               default:
                   $this->endDate->modify('+'.$this->session->getPrice()->getPremiumDelay().' day');
                   break;
           }
    }
      /**
    * @ORM\PostPersist()
    * @ORM\PostUpdate()
    */
    public function PostPersist(){

        //create inscrir au groupe
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
     * Set email
     *
     * @param string $email
     *
     * @return Info
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * Set studentId
     *
     * @param string $studentId
     * @return Abonnement
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
         $this->uid =$studentId;
        return $this;
    }

    /**
     * Get studentId
     *
     * @return string 
     */
    public function getStudentId()
    {
        return $this->uid;
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




    /**
     * Set session
     *
     * @param \AppBundle\Entity\Session $session
     *
     * @return Abonnement
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
     * Set info
     *
     * @param \Pwm\AdminBundle\Entity\Info $info
     *
     * @return Abonnement
     */
    public function setInfo(\Pwm\AdminBundle\Entity\Info $info = null)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return \Pwm\AdminBundle\Entity\Info
     */
    public function getInfo()
    {
        return $this->info;
    }
}
