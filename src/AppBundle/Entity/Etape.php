<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etape
 *
 * @ORM\Table(name="etape")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EtapeRepository")
 */
class Etape
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
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="time")
     */
    private $heure;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=6, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client",inversedBy="etapes")
     * @var User
     */
    protected $user;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Synchro",inversedBy="etapes")
   * 
   */
    private $synchro;
        /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Etape", cascade={"persist","remove"})
     * @var User
     */
    protected $suivant;

        /**
     * Constructor
     */
    public function __construct($user=null,$id=null, $type=null, $date=null,$heure=null,$longitude=null, $latitude=null,\AppBundle\Entity\Etape $suivant = null)
    {
      $this->user=$user;
      $this->type=$type;
      $this->date=$date;
      $this->heure=$heure;
      $this->longitude=$longitude;
      $this->latitude=$latitude;
     // $this->id=$id;
      $this->suivant=$suivant;
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
     * @return Etape
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
     * Set heure
     *
     * @param \DateTime $heure
     * @return Etape
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * Get heure
     *
     * @return \DateTime 
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Etape
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Etape
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Etape
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Etape
     */
    public function setUser(\AppBundle\Entity\Client $user = null)
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
     * Set suivant
     *
     * @param \AppBundle\Entity\Etape $suivant
     * @return Etape
     */
    public function setSuivant(\AppBundle\Entity\Etape $suivant = null)
    {
        $this->suivant = $suivant;

        return $this;
    }

    /**
     * Get suivant
     *
     * @return \AppBundle\Entity\Etape 
     */
    public function getSuivant()
    {
        return $this->suivant;
    }

    /**
     * Set synchro
     *
     * @param \AppBundle\Entity\Synchro $synchro
     * @return Etape
     */
    public function setSynchro(\AppBundle\Entity\Synchro $synchro = null)
    {
        $this->synchro = $synchro;

        return $this;
    }

    /**
     * Get synchro
     *
     * @return \AppBundle\Entity\Synchro 
     */
    public function getSynchro()
    {
        return $this->synchro;
    }
}
