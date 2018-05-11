<?php

namespace Pwm\MessagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sending
 *
 * @ORM\Table(name="sending")
 * @ORM\Entity(repositoryClass="Pwm\MessagerBundle\Repository\SendingRepository")
   *@ORM\HasLifecycleCallbacks()
 */
class Sending
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
   * @ORM\ManyToOne(targetEntity="Registration")
   */
    private $registration;

    /**
     * @var bool
     *
     * @ORM\Column(name="readed", type="boolean", nullable=true)
     */
    private $readed;

    /**
     * @var \DateTime
     * @ORM\Column(name="sendDate", type="datetime")
     */
    private $sendDate;

    /**
     * @ORM\ManyToOne(targetEntity="Notification", inversedBy="sendings")
     */
    private $notification;

    /**
     * Constructor
     */
    public function __construct(Registration $registration, Notification $notification)
    {
        $this->date =new \DateTime(); 
        $this->registration =$registration;   
        $this->notification =$notification; 
       // $this->sendDate =$notification->getSendDate();      
    }


 /**
  * @ORM\PrePersist
 */
 public function prePersist(){
 
   $this->sendDate =$this->notification->getSendDate();

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Sending
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
     * Set readed
     *
     * @param boolean $readed
     *
     * @return Sending
     */
    public function setReaded($readed)
    {
        $this->readed = $readed;

        return $this;
    }

    /**
     * Get readed
     *
     * @return bool
     */
    public function getReaded()
    {
        return $this->readed;
    }

    /**
     * Set sendDate
     *
     * @param \DateTime $sendDate
     *
     * @return Sending
     */
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;

        return $this;
    }

    /**
     * Get sendDate
     *
     * @return \DateTime
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * Set notification
     *
     * @param \Pwm\MessagerBundle\Entity\Notification $notification
     *
     * @return Sending
     */
    public function setNotification(\Pwm\MessagerBundle\Entity\Notification $notification = null)
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * Get notification
     *
     * @return \Pwm\MessagerBundle\Entity\Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }


    /**
     * Set registration
     *
     * @param \Pwm\MessagerBundle\Entity\Registration $registration
     *
     * @return Sending
     */
    public function setRegistration(\Pwm\MessagerBundle\Entity\Registration $registration = null)
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * Get registration
     *
     * @return \Pwm\MessagerBundle\Entity\Registration
     */
    public function getRegistration()
    {
        return $this->registration;
    }
}
