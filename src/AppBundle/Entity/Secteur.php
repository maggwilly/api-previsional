<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secteur
 *
 * @ORM\Table(name="secteur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SecteurRepository")
 */
class Secteur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id",  type="string", length=255)
     * @ORM\Id
     */
    private $id;


     /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;


   /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Quartier", mappedBy="secteur", cascade={"persist","remove"})
   */
    private $quartiers;


    /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\PointVente", mappedBy="secteur", cascade={"persist","remove"})
   */
    private $pointVentes;
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
     * Set numero
     *
     * @param integer $numero
     * @return Secteur
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }
    /**
     * Constructor
     */
    public function __construct($ville=null, $numero=null)
    {
        $this->id=$ville;//.$numero;
        $this->ville=$ville;
        $this->numero=$numero;
        $this->quartiers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add quartiers
     *
     * @param \AppBundle\Entity\Quartier $quartiers
     * @return Secteur
     */
    public function addQuartier(\AppBundle\Entity\Quartier $quartiers)
    {   
        $quartiers->setSecteur($this);
        $this->quartiers[] = $quartiers;

        return $this;
    }

    /**
     * Remove quartiers
     *
     * @param \AppBundle\Entity\Quartier $quartiers
     */
    public function removeQuartier(\AppBundle\Entity\Quartier $quartiers)
    {
        $this->quartiers->removeElement($quartiers);
    }

    /**
     * Get quartiers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuartiers()
    {
        return $this->quartiers;
    }

    /**
     * Add pointVentes
     *
     * @param \AppBundle\Entity\PointVente $pointVentes
     * @return Secteur
     */
    public function addPointVente(\AppBundle\Entity\PointVente $pointVentes)
    {
        $this->pointVentes[] = $pointVentes;

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

    /**
     * Set ville
     *
     * @param string $ville
     * @return Secteur
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }
}
