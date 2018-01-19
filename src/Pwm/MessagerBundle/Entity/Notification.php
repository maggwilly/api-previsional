<?php

namespace Pwm\MessagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="Pwm\MessagerBundle\Repository\NotificationRepository")
 */
class Notification
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
     * @ORM\Column(name="text", type="text")
     */
    private $text;


    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;
    /**
     * @var string
     *
     * @ORM\Column(name="sousTitre", type="text")
     */
    private $sousTitre;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $imageEntity;

    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="includeMail", type="boolean", nullable=true)
     */
    private $includeMail;

    /**
     * @var bool
     *
     * @ORM\Column(name="sendNow", type="boolean", nullable=true)
     */
    private $sendNow;

        /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

  /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Session")
   */
    private $session;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sendDate", type="datetime")
     */
    private $sendDate;

    /**
     * Constructor
     */
    public function __construct($type=null)
    {
        $this->date =new \DateTime();
        $this->sendDate =new \DateTime();
         $this->type =$type;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        if($this->imageEntity!=null)
           return $this->image=$this->imageEntity->getWebPath();
       return $this->image;
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Notification
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
     * Set text
     *
     * @param string $text
     *
     * @return Notification
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }


    /**
     * Set type
     *
     * @param string $type
     *
     * @return Pub
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
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set sousTitre
     *
     * @param string $sousTitre
     *
     * @return Notification
     */
    public function setSousTitre($sousTitre)
    {
        $this->sousTitre = $sousTitre;

        return $this;
    }

    /**
     * Get sousTitre
     *
     * @return string
     */
    public function getSousTitre()
    {
        return $this->sousTitre;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Notification
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Notification
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
     * Set includeMail
     *
     * @param boolean $includeMail
     *
     * @return Notification
     */
    public function setIncludeMail($includeMail)
    {
        $this->includeMail = $includeMail;

        return $this;
    }

    /**
     * Get includeMail
     *
     * @return bool
     */
    public function getIncludeMail()
    {
        return $this->includeMail;
    }

    /**
     * Set sendNow
     *
     * @param boolean $sendNow
     *
     * @return Notification
     */
    public function setSendNow($sendNow)
    {
        $this->sendNow = $sendNow;

        return $this;
    }

    /**
     * Get sendNow
     *
     * @return bool
     */
    public function getSendNow()
    {
        return $this->sendNow;
    }

    /**
     * Set sendDate
     *
     * @param \DateTime $sendDate
     *
     * @return Notification
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
     * Set imageEntity
     *
     * @param \AppBundle\Entity\Image $imageEntity
     *
     * @return Concours
     */
    public function setImageEntity(\AppBundle\Entity\Image $imageEntity = null)
    {
        $this->imageEntity = $imageEntity;

        return $this;
    }

    /**
     * Get imageEntity
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImageEntity()
    {
        return $this->imageEntity;
    }
       /**
     * Set type
     *
     * @param string $type
     *
     * @return Session
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
}
