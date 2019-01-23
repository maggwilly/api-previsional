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
     * @ORM\Column(name="month", type="integer", nullable=true)
     */
    private $month;

        /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @var User
     */
    protected $user;

        /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PointVente")
   */
    private $pointVente;

    /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ligne", mappedBy="commende", cascade={"persist","remove"})
   */
    private $lignes;



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
* @ORM\PrePersist
*/
 public function prePersist(){
    $this->week =$this->date->format("W");
    $this->month =$this->date->format("M");

     $year=$this->date->format("Y");
    $date = new \DateTime();
    $date->setISODate($year, $this->week);
    $startDate=$date->format('d/m');
    $date->modify('+6 days');
    $endDate=$date->format('d/m');
    $this->weekText=$startDate.' - '.$endDate;
  }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lignes = new \Doctrine\Common\Collections\ArrayCollection();
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
    {
        return $this->week;
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
}
