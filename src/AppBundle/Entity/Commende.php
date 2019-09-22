<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commende
 *
 * @ORM\Table(name="commende")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommendeRepository")
  *@ORM\HasLifecycleCallbacks()
 */
class Commende
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="string", unique=true)
     * @ORM\Id
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datesave", type="datetime")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="is_terminated", type="boolean", nullable=true)
     */
    private $terminated;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="terminated_date", type="datetime", nullable=true)
     */
    private $terminateddate;

    /**
     * @var int
     *
     * @ORM\Column(name="week", type="integer", nullable=true)
     */
    private $week;

        /**
     * @var int
     *
     * @ORM\Column(name="week_text", type="string", length=255, nullable=true)
     */
    private $weekText;


        /**
     * @var int
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;


        /**
     * @var int
     *
     * @ORM\Column(name="num_facture", type="string", length=255, nullable=true)
     */
    private $numFacture;
    /**
     * @var int
     *
     * @ORM\Column(name="month", type="string", length=255, nullable=true)
     */
    private $month;

        /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    protected $user;

        /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PointVente",inversedBy="commendes")
   * @ORM\JoinColumn(nullable=false)
   */
    private $pointVente;

    /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ligne", mappedBy="commende", cascade={"persist","remove","merge"},orphanRemoval=true)
   */
    private $lignes;

    private $stored=true;

    private $ca;

     private $quantite;
    /**
     * Constructor
     */
    public function __construct(User $user=null)
    {
        $this->lignes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user=$user;
        $this->date=new \DateTime();
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
    public function setId($id)
    {
        $this->id=$id;
        return $this;
    }
    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commende
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
* @ORM\PrePersist()
*/
 public function doStuffOnPersist(){
    $this->week =$this->date->format("W");
    //$this->terminated=is_null($this->terminated)?true:false;
  }
    /**
  @ORM\PreFlush
*/
 public function doStuffOnUpdate(){
      $this->terminated=is_null($this->terminated)?false:true;
    foreach ($this->lignes as $key => $ligne) {
        if($ligne->getProduit()==null){
          $this->removeLigne($ligne);
          continue;  
        }
         $ligne->setCommende($this);
    }
  }


    /**
     * Get week
     *
     * @return integer
     */
    public function getColisSum()
    {  $colisSum=0;
        foreach ($this->lignes as $key => $ligne) {
          $colisSum+=$ligne->getQuantite();
        }
      return $this->quantite=$colisSum;  
    }

    /**
     * Get week
     *
     * @return integer
     */
    public function getCaSum()
    {  $caSum=0;
        foreach ($this->lignes as $key => $ligne) {
          $caSum+=$ligne->getQuantite()*$ligne->getPu();
        }
      return $this->ca=$caSum;  
    }
    /**
     * Set week
     *
     * @param integer $week
     *
     * @return Commende
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
    {  /*if($this->week)
        return $this->week;*/
      return $this->date->format("W");  
    }


    /**
     * Set weekText
     *
     * @param string $weekText
     *
     * @return Commende
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
     * Set month
     *
     * @param integer $month
     *
     * @return Commende
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Commende
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
     * Set pointVente
     *
     * @param \AppBundle\Entity\PointVente $pointVente
     *
     * @return Commende
     */
    public function setPointVente(\AppBundle\Entity\PointVente $pointVente = null)
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
     * Add ligne
     *
     * @param \AppBundle\Entity\Ligne $ligne
     *
     * @return Commende
     */
    public function addLigne(\AppBundle\Entity\Ligne $ligne)
    {
        $this->lignes[] = $ligne;
        $ligne->setCommende($this);
        return $this;
    }

    /**
     * Remove ligne
     *
     * @param \AppBundle\Entity\Ligne $ligne
     */
    public function removeLigne(\AppBundle\Entity\Ligne $ligne)
    {
        $this->lignes->removeElement($ligne);
    }

    /**
     * Get lignes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLignes()
    {
        return $this->lignes;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Commende
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
     * Set numFacture
     *
     * @param string $numFacture
     *
     * @return Commende
     */
    public function setNumFacture($numFacture)
    {
        $this->numFacture = $numFacture;

        return $this;
    }

    /**
     * Get numFacture
     *
     * @return string
     */
    public function getNumFacture()
    {
        return $this->numFacture;
    }

    /**
     * Set terminated
     *
     * @param boolean $terminated
     *
     * @return Commende
     */
    public function setTerminated($terminated)
    {
        $this->terminated = $terminated;

        return $this;
    }

    /**
     * Get terminated
     *
     * @return boolean
     */
    public function getTerminated()
    {
        return $this->terminated;
    }

    /**
     * Set terminateddate
     *
     * @param \DateTime $terminateddate
     *
     * @return Commende
     */
    public function setTerminateddate($terminateddate)
    {
        $this->terminateddate = $terminateddate;

        return $this;
    }

    /**
     * Get terminateddate
     *
     * @return \DateTime
     */
    public function getTerminateddate()
    {
        return $this->terminateddate;
    }
}
