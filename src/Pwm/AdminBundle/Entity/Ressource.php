<?php

namespace Pwm\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ressource
 *
 * @ORM\Table(name="ressource")
 * @ORM\Entity(repositoryClass="Pwm\AdminBundle\Repository\RessourceRepository")
 */
class Ressource
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="detail1", type="string", length=255, nullable=true)
     */
    private $detail1;

    /**
     * @var string
     *
     * @ORM\Column(name="detail2", type="string", length=255, nullable=true)
     */
    private $detail2;

    /**
     * @var string
     *
     * @ORM\Column(name="detail3", type="string", length=255, nullable=true)
     */
    private $detail3;

     /**
     * @var string
     *
     * @ORM\Column(name="detail4", type="string", length=255, nullable=true)
     */
    private $detail4;   

    /**
     * @var string
     *
     * @ORM\Column(name="style", type="string", length=255, nullable=true)
     */
    private $style;

     /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255, nullable=true)
     */
    private $size;   


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=true)
     */
    private $label;
    /**
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="string", length=255)
     */
    private $imageUrl;

      /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Session" )
   */
    private $session;
    /**
     * @var string
     *
     * @ORM\Column(name="paymentUrl", type="string", length=255)
     */
    private $paymentUrl; 
    /**
     * Constructor
     */
    public function __construct(\AppBundle\Entity\Session $session=null)
    {
        $this->date =new \DateTime(); 
        $this->session = $session; 
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
     * Set price
     *
     * @param integer $price
     *
     * @return Ressource
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Ressource
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Ressource
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set detail1
     *
     * @param string $detail1
     *
     * @return Ressource
     */
    public function setDetail1($detail1)
    {
        $this->detail1 = $detail1;

        return $this;
    }

    /**
     * Get detail1
     *
     * @return string
     */
    public function getDetail1()
    {
        return $this->detail1;
    }

    /**
     * Set detail2
     *
     * @param string $detail2
     *
     * @return Ressource
     */
    public function setDetail2($detail2)
    {
        $this->detail2 = $detail2;

        return $this;
    }

    /**
     * Get detail2
     *
     * @return string
     */
    public function getDetail2()
    {
        return $this->detail2;
    }

    /**
     * Set detail3
     *
     * @param string $detail3
     *
     * @return Ressource
     */
    public function setDetail3($detail3)
    {
        $this->detail3 = $detail3;

        return $this;
    }

    /**
     * Get detail3
     *
     * @return string
     */
    public function getDetail4()
    {
        return $this->detail4;
    }
    /**
     * Set detail3
     *
     * @param string $detail3
     *
     * @return Ressource
     */
    public function setDetail4($detail3)
    {
        $this->detail4 = $detail3;

        return $this;
    }

    /**
     * Get detail3
     *
     * @return string
     */
    public function getDetail3()
    {
        return $this->detail3;
    }
    /**
     * Set url
     *
     * @param string $url
     *
     * @return Ressource
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
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Ressource
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set session
     *
     * @param \AppBundle\Entity\Session $session
     *
     * @return Ressource
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
     * Set style
     *
     * @param string $style
     *
     * @return Ressource
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Ressource
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Ressource
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set paymentUrl
     *
     * @param string $paymentUrl
     *
     * @return Ressource
     */
    public function setPaymentUrl($paymentUrl)
    {
        $this->paymentUrl = $paymentUrl;

        return $this;
    }

    /**
     * Get paymentUrl
     *
     * @return string
     */
    public function getPaymentUrl()
    {
        return $this->paymentUrl;
    }
}
