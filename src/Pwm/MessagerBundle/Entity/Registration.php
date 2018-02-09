<?php

namespace Pwm\MessagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Registration
 *
 * @ORM\Table(name="registration")
 * @ORM\Entity(repositoryClass="Pwm\MessagerBundle\Repository\RegistrationRepository")
 */
class Registration
{

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=255, unique=true)
     * @ORM\Id
     */
    private $registrationId;


    /**
     * @var string
     *
     * @ORM\Column(name="user_agent", type="string", length=255, nullable=true)
     */
    private $userAgent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

        /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login_date", type="datetime", nullable=true)
     */
    private $latLoginDate;

     /**
   * @ORM\ManyToOne(targetEntity="Pwm\AdminBundle\Entity\Info", inversedBy="registrations", cascade={"persist"})
   * @ORM\JoinColumn(referencedColumnName="uid")
   */
     private  $info;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date =new \DateTime();  
        $this->latLoginDate =new \DateTime();  
        
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Registration
     */
    public function setUserAgent($date)
    {
        $this->userAgent = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set registrationId
     *
     * @param string $registrationId
     *
     * @return Registration
     */
    public function setRegistrationId($registrationId)
    {
        $this->registrationId = $registrationId;

        return $this;
    }

    /**
     * Get registrationId
     *
     * @return string
     */
    public function getRegistrationId()
    {
        return $this->registrationId;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Registration
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
     * Set info
     *
     * @param \Pwm\AdminBundle\Entity\Info $info
     *
     * @return Registration
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

    /**
     * Set latLoginDate
     *
     * @param \DateTime $latLoginDate
     *
     * @return Registration
     */
    public function setLatLoginDate($latLoginDate)
    {
        $this->latLoginDate = $latLoginDate;

        return $this;
    }

    /**
     * Get latLoginDate
     *
     * @return \DateTime
     */
    public function getLatLoginDate()
    {
        return $this->latLoginDate;
    }
}
