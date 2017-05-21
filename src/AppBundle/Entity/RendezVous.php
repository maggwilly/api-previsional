<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RendezVous
 *
 * @ORM\Table(name="rendez_vous")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RendezVousRepository")
 */
class RendezVous
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   */
    private $user;



   /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_rdv", type="date")
     */
    private $dateRdv;
    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
   */
    private $client;

        /**
     * @var string
     *
     * @ORM\Column(name="compter_rendu", type="string", length=255, nullable=true)
     */
    private $compteRendu;
 
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="time", nullable=true)
     */
    private $heure;

    /**
     * @var string
     *
     * @ORM\Column(name="rapport", type="string", length=255, nullable=true)
     */
    private $rapport;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255, nullable=true)
     */
    private $lieu;

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
     * @return RendezVous
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
     * @return RendezVous
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
     * Set rapport
     *
     * @param string $rapport
     * @return RendezVous
     */
    public function setRapport($rapport)
    {
        $this->rapport = $rapport;

        return $this;
    }

    /**
     * Get rapport
     *
     * @return string 
     */
    public function getRapport()
    {
        return $this->rapport;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return RendezVous
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
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     * @return RendezVous
     */
    public function setClient(\AppBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set compteRendu
     *
     * @param string $compteRendu
     * @return RendezVous
     */
    public function setCompteRendu($compteRendu)
    {
        $this->compteRendu = $compteRendu;

        return $this;
    }

    /**
     * Get compteRendu
     *
     * @return string 
     */
    public function getCompteRendu()
    {
        return $this->compteRendu;
    }

    /**
     * Set dateRdv
     *
     * @param \DateTime $dateRdv
     * @return Phoning
     */
    public function setDateRdv($dateRdv)
    {
        $this->dateRdv = $dateRdv;

        return $this;
    }

    /**
     * Get dateRdv
     *
     * @return \DateTime 
     */
    public function getDateRdv()
    {
        return $this->dateRdv;
    }    

    /**
     * Set lieu
     *
     * @param string $lieu
     * @return RendezVous
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string 
     */
    public function getLieu()
    {
        return $this->lieu;
    }
}
