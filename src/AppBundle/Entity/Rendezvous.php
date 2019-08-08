<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rendezvous
 *
 * @ORM\Table(name="rendezvous")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RendezvousRepository")
   *@ORM\HasLifecycleCallbacks()
 */
class Rendezvous
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", unique=true)
     * @ORM\Id
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateat", type="date")
     */
    private $dateat;

    private $realdateat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    private $passdays;

    private $previsions;

     private $produitnonvendu;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;

        /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @var User
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @var User
     */
    private $createdBy;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PointVente",inversedBy="rendezvouss")
   */
    private $pointVente;

    private $stored=true;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="persist", type="boolean", nullable=true)
     */
    private $persist;

    /**
     * Constructor
     */
    public function __construct(
           \DateTime $dateat=null,
           \AppBundle\Entity\PointVente $pointVente = null,
           \AppBundle\Entity\User $user = null,
           $stored=true
    )
    {
         $this->date =new \DateTime(); 
         $this->dateat =$dateat!=null?clone $dateat:$dateat; 
         $this->createdBy =$user;  
         $this->pointVente=$pointVente;
         $this->previsions=[];
         $this->stored=$stored;
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
     * Set nom
     *
     * @param string $id
     *
     * @return Secteur
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /** @ORM\PostLoad */
    public function doStuffOnPostLoad()
    {
         $today=new \DateTime(date('Y-M-D'));  
         $interval=$today->diff($this->dateat); 
        $this->passdays=(int)$interval->format('%R%a'); 
        $this->previsions=[];
        if ($this->user==null) {
            $this->user=$this->createdBy;
        }
    }

        /**
* @ORM\PrePersist()
*/
 public function doStuffOnPersist(){
      
    if(!$this->id)
         $this->id=md5(uniqid());    
   // $this->doStuffOnUpdate();
  }
    /**
     * Set dateat
     *
     * @param \DateTime $dateat
     * @return Rendezvous
     */
    public function setDateat($dateat)
    {  
        if($dateat==null)
            return $this;
          $this->dateat=$dateat;
          $this->doStuffOnPostLoad();
        return $this;
    }
    /**
     * Get week
     *
     * @return integer
     */
    public function getColisSum()
    {  $colisSum=0;
        foreach ($this->previsions as $key => $prevision) {
           if(array_key_exists('next_cmd_quantity', $prevision))
              $colisSum+=$prevision['next_cmd_quantity'];
        }
      return $colisSum;  
    }

    /**
     * Get week
     *
     * @return integer
     */
    public function getCaSum()
    {  $caSum=0;
        foreach ($this->previsions as $key => $prevision) {
           if(array_key_exists('next_cmd_cost', $prevision))
              $caSum+=$prevision['next_cmd_cost'];
        }
      return $caSum;  
    }
    /**
     * Get dateat
     *
     * @return \DateTime
     */
    public function getDateat()
    {
        return $this->dateat;
    }

    /**
     * Get week
     *
     * @return integer
     */
    public function getWeek()
    {  
      return $this->dateat->format("W");  
    }
    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Rendezvous
     */
    public function setDate($date)
    {

        $this->date = $date;

        return $this;
    }

    public function addPrevisions($previsions)
    {
        $this->previsions[]=$previsions;
        if(!array_key_exists('last_cmd_date', $previsions))
           $this->produitnonvendu++;
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
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Rendezvous
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Rendezvous
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Rendezvous
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
     * @return Rendezvous
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
     * Set persist
     *
     * @param boolean $persist
     *
     * @return Rendezvous
     */
    public function setPersist($persist)
    {
        $this->persist = $persist;

        return $this;
    }

    /**
     * Get persist
     *
     * @return boolean
     */
    public function getPersist()
    {
        return $this->persist;
    }
    /**
     * Set persist
     *
     * @param boolean $stored
     *
     * @return Rendezvous
     */
    public function setStored($stored)
    {
        $this->stored = $stored;

        return $this;
    }

    /**
     * Get stored
     *
     * @return boolean
     */
    public function getStored()
    {
        return $this->stored;
    }
    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return Rendezvous
     */
    public function setCreatedBy(\AppBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}
