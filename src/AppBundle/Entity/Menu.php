<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MenuRepository")
 */
class Menu
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
     * @ORM\Column(name="theme", type="string", length=255, nullable=true)
     */
    private $theme;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSave", type="date",unique=true)
     */
    private $dateSave;

    /**
     * @var bool
     *
     * @ORM\Column(name="special", type="boolean", nullable=true)
     */
    private $special;


 /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\Plat", mappedBy="menu",cascade={"persist","remove"})
   */
    private $plats;
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
     * Set theme
     *
     * @param string $theme
     * @return Menu
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string 
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set dateSave
     *
     * @param \DateTime $dateSave
     * @return Menu
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
     * Set special
     *
     * @param boolean $special
     * @return Menu
     */
    public function setSpecial($special)
    {
        $this->special = $special;

        return $this;
    }

    /**
     * Get special
     *
     * @return boolean 
     */
    public function getSpecial()
    {
        return $this->special;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->plats = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add plats
     *
     * @param \AppBundle\Entity\Plat $plats
     * @return Menu
     */
    public function addPlat(\AppBundle\Entity\Plat $plats)
    {
        $this->plats[] = $plats;
        $plats->setMenu($this);

        return $this;
    }

    /**
     * Remove plats
     *
     * @param \AppBundle\Entity\Plat $plats
     */
    public function removePlat(\AppBundle\Entity\Plat $plats)
    {
        $this->plats->removeElement($plats);
    }

    /**
     * Get plats
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlats()
    {
        return $this->plats;
    }
}
