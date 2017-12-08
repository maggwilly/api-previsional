<?php

namespace Pwm\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Price
 *
 * @ORM\Table(name="price")
 * @ORM\Entity(repositoryClass="Pwm\AdminBundle\Repository\PriceRepository")
 */
class Price
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
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="starter", type="integer")
     */
    private $starter;

    /**
     * @var int
     *
     * @ORM\Column(name="standard", type="integer")
     */
    private $standard;

    /**
     * @var int
     *
     * @ORM\Column(name="premium", type="integer")
     */
    private $premium;


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
     * @return Price
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
     * Set starter
     *
     * @param integer $starter
     *
     * @return Price
     */
    public function setStarter($starter)
    {
        $this->starter = $starter;

        return $this;
    }

    /**
     * Get starter
     *
     * @return int
     */
    public function getStarter()
    {
        return $this->starter;
    }

    /**
     * Set standard
     *
     * @param integer $standard
     *
     * @return Price
     */
    public function setStandard($standard)
    {
        $this->standard = $standard;

        return $this;
    }

    /**
     * Get standard
     *
     * @return int
     */
    public function getStandard()
    {
        return $this->standard;
    }

    /**
     * Set premium
     *
     * @param integer $premium
     *
     * @return Price
     */
    public function setPremium($premium)
    {
        $this->premium = $premium;

        return $this;
    }

    /**
     * Get premium
     *
     * @return int
     */
    public function getPremium()
    {
        return $this->premium;
    }
}

