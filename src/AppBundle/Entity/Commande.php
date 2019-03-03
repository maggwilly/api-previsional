<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeRepository")
  * @ORM\HasLifecycleCallbacks
 */
class Commande
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=255, nullable=true)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

        /**
     * @var string
     *
     * @ORM\Column(name="order_id", type="string", length=255, nullable=true)
     */
    private $order_id;


            /**
     * @var string
     *
     * @ORM\Column(name="txnid", type="string", length=255, nullable=true)
     */
    private $txnid;


        /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @var User
     */
    protected $user;

  /**
   * @ORM\OneToOne(targetEntity="AppBundle\Entity\Abonnement")
   */
    private $abonnement;


        /**
     * @var string
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;


        /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Price")
     * @var User
     */
    protected $price;

    /**
     * @var string
     *
     * @ORM\Column(name="method", type="string", length=255, nullable=true)
     */
    private $method;


        /**
     * Constructor
     */
    public function __construct(\AppBundle\Entity\User $user = null)
    {
        $this->date =new \DateTime();  
         $this->user =$user;  
    }

    /**
     *@ORM\Prepersist()
    * @ORM\PreUpdate()
    */
    public function PreUpdate(){
         $this->date =new \DateTime();
         switch ($this->duree) {
             case 1:
                $this->amount=$this->price->getAmount();
                 break;
             case 6:
                 $this->amount=$this->price->getAmount()*5;
                 break;            
             default:
                 $this->amount=$this->price->getAmount()*10;
                 break;
         }
    }

public function getUId() {

        return strtoupper(uniqid());
    }
    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commande
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
     * Set amount
     *
     * @param integer $amount
     *
     * @return Commande
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return Commande
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }


    /**
     * Set duree
     *
     * @param integer $duree
     *
     * @return Price
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return int
     */
    public function getDuree()
    {
        return $this->duree;
    }


    /**
     * Set status
     *
     * @param string $status
     *
     * @return Commande
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
     * Set txnid
     *
     * @param string $txnid
     *
     * @return Commande
     */
    public function setTxnid($txnid)
    {
        $this->txnid = $txnid;

        return $this;
    }

    /**
     * Get txnid
     *
     * @return string
     */
    public function getTxnid()
    {
        return $this->txnid;
    }

    /**
     * Set orderId
     *
     * @param string $orderId
     *
     * @return Commande
     */
    public function setOrderId($orderId)
    {
        $this->order_id = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set abonnement
     *
     * @param \Pwm\AdminBundle\Entity\Abonnement $abonnement
     *
     * @return Commande
     */
    public function setAbonnement(\AppBundle\Entity\Abonnement $abonnement = null)
    {
        $this->abonnement = $abonnement;

        return $this;
    }

    /**
     * Get abonnement
     *
     * @return \Pwm\AdminBundle\Entity\Abonnement
     */
    public function getAbonnement()
    {
        return $this->abonnement;
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

}
