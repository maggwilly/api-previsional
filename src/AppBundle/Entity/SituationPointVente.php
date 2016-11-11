<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SituationPointVente
 *
 * @ORM\Table(name="situation_point_vente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SituationPointVenteRepository")
 */
class SituationPointVente
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
     * @ORM\Column(name="date_save", type="datetime")
     */
    private $dateSave;

    /**
     * @var int
     *
     * @ORM\Column(name="visibilite", type="integer")
     */
    private $visibilite;

    /**
     * @var bool
     *
     * @ORM\Column(name="respect_prix", type="boolean")
     */
    private $respectPrix;

    /**
     * @var string
     *
     * @ORM\Column(name="stock_actuel", type="integer", length=255)
     */
    private $stockActuel;

     /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PointVente")
   * @ORM\JoinColumn(nullable=false)
   */
  
    private $PointVente;


      /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
   * @ORM\JoinColumn(nullable=false)
   */
    private $user;

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
     * Set dateSave
     *
     * @param \DateTime $dateSave
     * @return SituationPointVente
     */
    public function setDateSave($dateSave)
    {
        $this->dateSave = $dateSave;

        return $this;
    }

    /**
     * Get dateSave
     *
     * @return \DateTime 
     */
    public function getDateSave()
    {
        return $this->dateSave;
    }

    /**
     * Set visibilite
     *
     * @param integer $visibilite
     * @return SituationPointVente
     */
    public function setVisibilite($visibilite)
    {
        $this->visibilite = $visibilite;

        return $this;
    }

    /**
     * Get visibilite
     *
     * @return integer 
     */
    public function getVisibilite()
    {
        return $this->visibilite;
    }

    /**
     * Set respectPrix
     *
     * @param boolean $respectPrix
     * @return SituationPointVente
     */
    public function setRespectPrix($respectPrix)
    {
        $this->respectPrix = $respectPrix;

        return $this;
    }

    /**
     * Get respectPrix
     *
     * @return boolean 
     */
    public function getRespectPrix()
    {
        return $this->respectPrix;
    }

    /**
     * Set stockActuel
     *
     * @param string $stockActuel
     * @return SituationPointVente
     */
    public function setStockActuel($stockActuel)
    {
        $this->stockActuel = $stockActuel;

        return $this;
    }

    /**
     * Get stockActuel
     *
     * @return string 
     */
    public function getStockActuel()
    {
        return $this->stockActuel;
    }

    /**
     * Set PointVente
     *
     * @param \AppBundle\Entity\PointVente $pointVente
     * @return SituationPointVente
     */
    public function setPointVente(\AppBundle\Entity\PointVente $pointVente)
    {
        $this->PointVente = $pointVente;

        return $this;
    }

    /**
     * Get PointVente
     *
     * @return \AppBundle\Entity\PointVente 
     */
    public function getPointVente()
    {
        return $this->PointVente;
    }

      /**
     * Set user
     *
     * @param \AppBundle\Entity\Client $user
     * @return PointVente
     */
    public function setUser(\AppBundle\Entity\Client $user)
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
}
