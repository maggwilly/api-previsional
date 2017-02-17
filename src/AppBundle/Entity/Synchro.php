<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Synchro
 *
 * @ORM\Table(name="synchro")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SynchroRepository")
 */
class Synchro
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=255)
    * @ORM\Id
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client",inversedBy="synchros")
      @ORM\JoinColumn(nullable=true)
     * @var User
     */
    protected $user;
   /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Visite", mappedBy="synchro", cascade={"persist","remove"})
   *@ORM\OrderBy({"date" = "DESC"})
   */
    private $visites;

    /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\PointVente", mappedBy="synchro", cascade={"persist","remove"})
   *@ORM\OrderBy({"date" = "DESC"})
   */
    private $pointVentes;


      /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Etape", mappedBy="synchro", cascade={"persist","remove"})
   *@ORM\OrderBy({"date" = "DESC"})
   */
    private $etapes;
        /**
     * Constructor
     */
    public function __construct($user=null, $date=null)
    {
       $this->user=$user;
      $this->date=$date;
        $this->id=uniqid();
    
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
     * Set id
     *
     * @param string $id
     * @return PointVente
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Synchro
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
     * Set status
     *
     * @param string $status
     * @return Synchro
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
     * Set user
     *
     * @param \AppBundle\Entity\Client $user
     * @return Synchro
     */
    public function setUser(\AppBundle\Entity\Client $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\Client 
     */
    public function getUser()
    {
        return $this->user;
    }

         /**
     * Add visites
     *
     * @param \AppBundle\Entity\Visite $visites
     * @return PointVente
     */
    public function addVisite(\AppBundle\Entity\Visite $visite)
    {
        $visite->setSynchro($this);
         $visite->setUser($this->user);
        $this->visites[] = $visite;

        return $this;
    }

    /**
     * Remove visites
     *
     * @param \AppBundle\Entity\Visite $visites
     */
    public function removeVisite(\AppBundle\Entity\Visite $visites)
    {
        $this->visites->removeElement($visites);
    }

    /**
     * Get visites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVisites()
    {
        return $this->visites;
    }
      /**
     * Add etapes
     *
     * @param \AppBundle\Entity\Etape $etapes
     * @return User
     */
    public function addEtape(\AppBundle\Entity\Etape $etapes)
    {
        $etapes->setSynchro($this);
        $etapes->setUser($this->user);  
        $this->etapes[] = $etapes;
             if($etapes->getSuivant()!=null)
              return $this->addEtape($etapes->getSuivant());

        return $this;
    }

    /**
     * Remove etapes
     *
     * @param \AppBundle\Entity\Etape $etapes
     */
    public function removeEtape(\AppBundle\Entity\Etape $etapes)
    {
        $this->etapes->removeElement($etapes);
    }

    /**
     * Get etapes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEtapes()
    {
        return $this->etapes;
    } 

      /**
     * Add pointVentes
     *
     * @param \AppBundle\Entity\PointVente $pointVentes
     * @return User
     */
    public function addPointVente(\AppBundle\Entity\PointVente $pointVentes)
    {
          $pointVentes->setSynchro($this);
         $pointVentes->setUser($this->user);
          $this->pointVentes[] =$pointVentes;

        return $this;
    }

    /**
     * Remove pointVentes
     *
     * @param \AppBundle\Entity\PointVente $pointVentes
     */
    public function removePointVente(\AppBundle\Entity\PointVente $pointVentes)
    {
        $this->pointVentes->removeElement($pointVentes);
    }

    /**
     * Get pointVentes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPointVentes()
    {
        return $this->pointVentes;
    }    
}
