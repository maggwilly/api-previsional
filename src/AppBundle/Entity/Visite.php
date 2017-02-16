<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visite
 *
 * @ORM\Table(name="visite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VisiteRepository")
  *@ORM\HasLifecycleCallbacks()
 */
class Visite
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
     * @var bool
     *
     * @ORM\Column(name="map", type="boolean", nullable=true)
     */
    private $map;

    /**
     * @var bool
     *
     * @ORM\Column(name="pre", type="boolean", nullable=true)
     */
    private $pre;

    /**
     * @var bool
     *
     * @ORM\Column(name="aff", type="boolean", nullable=true)
     */
    private $aff;

    /**
     * @var bool
     *
     * @ORM\Column(name="exc", type="boolean", nullable=true)
     */
    private $exc;

    /**
     * @var string
     *
     * @ORM\Column(name="vpt", type="boolean",  nullable=true)
     */
    private $vpt;

    /**
     * @var string
     *
     * @ORM\Column(name="sapp", type="boolean",  nullable=true)
     */
    private $sapp;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;
    /**
     * @var string
     *
     * @ORM\Column(name="fp",  type="integer", nullable=true)
     */
    private $fp;

        /**
     * @var bool
     *
     * @ORM\Column(name="rpp", type="boolean", nullable=true)
     */
    private $rpp;

    /**
     * @var bool
     *
     * @ORM\Column(name="rpd", type="boolean", nullable=true)
     */
    private $rpd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="week", type="integer")
     */
    private $week;

   /**
     * @var string
     *
     * @ORM\Column(name="week_text", type="string", length=255)
     */
    private $weekText;

    /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Situation", mappedBy="visite", cascade={"persist","remove"})
   */
    private $situations;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PointVente",inversedBy="visites")
   * @ORM\JoinColumn(nullable=false)
   */
  
    private $pointVente;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client",inversedBy="visites")
      @ORM\JoinColumn(nullable=true)
     * @var User
     */
    protected $user;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Synchro",inversedBy="visites")
   * 
   */
  
    private $synchro;

        /**
     * Constructor
     */
    public function __construct($user=null,$id=null,$date=null,$pointVente=null,$aff=null,$sapp=null,$exc=null,$map=null,$pre=null,$rpd=null,$rpp=null)
    {
     $this->user=$user;
      $this->date=$date;
      //$this->id=$id;
      $this->pointVente = $pointVente;
      $this->aff=$aff;
      $this->sapp=$sapp;
      $this->exc=$exc;
      $this->map=$map;
      $this->pre=$pre;
      $this->rpd=$rpd;
      $this->rpp=$rpp;
      $this->situations = new \Doctrine\Common\Collections\ArrayCollection();
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
* @ORM\PrePersist
*/
 public function prePersist(){
     $this->week =$this->date->format("W");
     $year=$this->date->format("Y");
    $date = new \DateTime();
    $date->setISODate($year, $this->week);
    $startDate=$date->format('d/m/Y');
    $date->modify('+6 days');
    $endDate=$date->format('d/m/Y');
    $this->weekText=$startDate.' - '.$endDate;
  }
    /**
     * Set map
     *
     * @param boolean $map
     * @return Visite
     */
    public function setMap($map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map
     *
     * @return boolean 
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set pre
     *
     * @param boolean $pre
     * @return Visite
     */
    public function setPre($pre)
    {
        $this->pre = $pre;

        return $this;
    }

    /**
     * Get pre
     *
     * @return boolean 
     */
    public function getPre()
    {
        return $this->pre;
    }

    /**
     * Set aff
     *
     * @param boolean $aff
     * @return Visite
     */
    public function setAff($aff)
    {
        $this->aff = $aff;

        return $this;
    }

    /**
     * Get aff
     *
     * @return boolean 
     */
    public function getAff()
    {
        return $this->aff;
    }

    /**
     * Set exc
     *
     * @param boolean $exc
     * @return Visite
     */
    public function setExc($exc)
    {
        $this->exc = $exc;

        return $this;
    }

    /**
     * Get exc
     *
     * @return boolean 
     */
    public function getExc()
    {
        return $this->exc;
    }

    /**
     * Set vpt
     *
     * @param string $vpt
     * @return Visite
     */
    public function setVpt($vpt)
    {
        $this->vpt = $vpt;

        return $this;
    }

    /**
     * Get vpt
     *
     * @return string 
     */
    public function getVpt()
    {
        return $this->vpt;
    }

    /**
     * Set sapp
     *
     * @param string $sapp
     * @return Visite
     */
    public function setSapp($sapp)
    {
        $this->sapp = $sapp;

        return $this;
    }

    /**
     * Get sapp
     *
     * @return string 
     */
    public function getSapp()
    {
        return $this->sapp;
    }

    /**
     * Set fp
     *
     * @param string $fp
     * @return Visite
     */
    public function setFp($fp)
    {
        $this->fp = $fp;

        return $this;
    }

    /**
     * Get fp
     *
     * @return string 
     */
    public function getFp()
    {
        return $this->fp;
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
     * Add situations
     *
     * @param \AppBundle\Entity\Situation $situations
     * @return Visite
     */
    public function addSituation(\AppBundle\Entity\Situation $situation)
    {
        $situation->setVisite($this);
        $this->situations[] = $situation;
      

        return $this;
    }

    /**
     * Remove situations
     *
     * @param \AppBundle\Entity\Situation $situations
     */
    public function removeSituation(\AppBundle\Entity\Situation $situations)
    {
        $this->situations->removeElement($situations);
    }

    /**
     * Get situations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSituations()
    {
        return $this->situations;
    }

    /**
     * Set pointVente
     *
     * @param \AppBundle\Entity\PointVente $pointVente
     * @return Visite
     */
    public function setPointVente(\AppBundle\Entity\PointVente $pointVente)
    {
        $this->pointVente = $pointVente;

        return $this;
    }

    /**
     * Get pointVente
     *
     * @return \AppBundle\Entity\PointVente 
     */
    public function getPointVente()
    {
        return $this->pointVente;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Visite
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
     * Set rpp
     *
     * @param boolean $rpp
     * @return Situation
     */
    public function setRpp($rpp)
    {
        $this->rpp = $rpp;

        return $this;
    }

    /**
     * Get rpp
     *
     * @return boolean 
     */
    public function getRpp()
    {
        return $this->rpp;
    }

    /**
     * Set rpd
     *
     * @param boolean $rpd
     * @return Situation
     */
    public function setRpd($rpd)
    {
        $this->rpd = $rpd;

        return $this;
    }

    /**
     * Get rpd
     *
     * @return boolean 
     */
    public function getRpd()
    {
        return $this->rpd;
    }   

    /**
     * Set week
     *
     * @param integer $week
     * @return Visite
     */
    public function setWeek($week)
    {
        $this->week = $week;

        return $this;
    }

    /**
     * Get week
     *
     * @return integer 
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * Set weekText
     *
     * @param string $weekText
     * @return Visite
     */
    public function setWeekText($weekText)
    {
        $this->weekText = $weekText;

        return $this;
    }

    /**
     * Get weekText
     *
     * @return string 
     */
    public function getWeekText()
    {
        return $this->weekText;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Visite
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set synchro
     *
     * @param \AppBundle\Entity\Synchro $synchro
     * @return Visite
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
