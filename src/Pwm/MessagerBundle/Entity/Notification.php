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
     * @ORM\Column(name="tag", type="string", length=255, options={"default" : "public"})
     */
    private $tag; 

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
     * @var bool
     *
     * @ORM\Column(name="includChat", type="boolean", nullable=true)
     */
    private $includChat;

    /**
     * @var string
     *
     * @ORM\Column(name="format", type="string", length=255, nullable=true)
     */
    private $format;

    /**
   * @ORM\ManyToOne(targetEntity="Pwm\AdminBundle\Entity\Groupe")
   */
    private $groupe;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sendDate", type="datetime")
     */
    private $sendDate;

    /**
   * @ORM\OneToMany(targetEntity="Sending", mappedBy="notification", cascade={"remove"})
   * @ORM\OrderBy({ "id" = "ASC"})
   */
    private $sendings;

    private $note;

    private $taux;   

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   */
    private $user;


    /**
     * Constructor
     */
    public function __construct($type='public', $includeMail=true,$includChat=false)
    {
        $this->date =new \DateTime();
        $this->sendDate =new \DateTime();
         $this->type =$type;
        $this->includeMail =$includeMail;
        $this->includChat =$includChat;
        $this->tag ='public';
        $this->format ='notifications';
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
     * Set taux
     *
     * @param string $taux
     *
     * @return Notification
     */
    public function setTaux($taux)
    {
        $this->taux = $taux;

        return $this;
    }

    /**
     * Get taux
     *
     * @return string
     */
    public function getTaux()
    {
        return $this->taux;
    }
    /**
     * Set taux
     *
     * @param string $note
     *
     * @return Notification
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
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
     * Set format
     *
     * @param string $format
     *
     * @return Notification
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set groupe
     *
     * @param \Pwm\AdminBundle\Entity\Groupe $groupe
     *
     * @return Notification
     */
    public function setGroupe(\Pwm\AdminBundle\Entity\Groupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \Pwm\AdminBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Add sending
     *
     * @param \Pwm\MessagerBundle\Entity\Sending $sending
     *
     * @return Notification
     */
    public function addSending(\Pwm\MessagerBundle\Entity\Sending $sending)
    {
        $this->sendings[] = $sending;

        return $this;
    }

    /**
     * Remove sending
     *
     * @param \Pwm\MessagerBundle\Entity\Sending $sending
     */
    public function removeSending(\Pwm\MessagerBundle\Entity\Sending $sending)
    {
        $this->sendings->removeElement($sending);
    }

    /**
     * Get sendings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSendings()
    {
        return $this->sendings;
    }
}
