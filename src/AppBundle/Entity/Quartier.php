<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quartier
 *
 * @ORM\Table(name="quartier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuartierRepository")
 */
class Quartier
{

    /**
     * @var int
     * @ORM\Column(name="id", type="string", length=255)
     * @ORM\Id
     */
    private $id;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Secteur", inversedBy="quartiers")
   * @ORM\JoinColumn(nullable=false)
   */
    private $secteur;


    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Synchro",inversedBy="pointVentes")
   * 
   */
    private $synchro;

        /**
     * Constructor
     */
    public function __construct($id=null,\AppBundle\Entity\Secteur $secteur=null)
    {
        $this->id=$id;
        $this->secteur = $secteur;
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
     * Set nom
     *
     * @param string $nom
     * @return Quartier
     */
    public function setId($nom)
    {
        $this->id = $nom;

        return $this;
    }

    
    /**
     * Set secteur
     *
     * @param \AppBundle\Entity\Secteur $secteur
     * @return Quartier
     */
    public function setSecteur(\AppBundle\Entity\Secteur $secteur)
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * Get secteur
     *
     * @return \AppBundle\Entity\Secteur 
     */
    public function getSecteur()
    {
        return $this->secteur;
    }

        /**
     * Set synchro
     * @param \AppBundle\Entity\Synchro $synchro
     * @return PointVente
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
