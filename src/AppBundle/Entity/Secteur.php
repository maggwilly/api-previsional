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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @var User
     */
    protected $user;
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

   /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\PointVente", mappedBy="secteur", cascade={"persist","remove"})
   */
    private $pointVentes;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Secteur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Secteur
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
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
    /**
     * Constructor
     */
    public function __construct(User $user=null)
    {
         $this->user=$user->getParent();
        $this->pointVentes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add pointVente
     *
     * @param \AppBundle\Entity\PointVente $pointVente
     *
     * @return Secteur
     */
    public function addPointVente(\AppBundle\Entity\PointVente $pointVente)
    {
        $this->pointVentes[] = $pointVente;

        return $this;
    }

    /**
     * Remove pointVente
     *
     * @param \AppBundle\Entity\PointVente $pointVente
     */
    public function removePointVente(\AppBundle\Entity\PointVente $pointVente)
    {
        $this->pointVentes->removeElement($pointVente);
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
