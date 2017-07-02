<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidat
 *
 * @ORM\Table(name="candidat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CandidatRepository")
 */
class Candidat
{

      /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="studentId", type="string", length=255, unique=true)
     */
     private $studentId;

      /**
     * @var string
     * @ORM\Column(name="uid", type="string", length=255, nullable=true)
     */
    private $uid;
    /**
     * @var string
     *
     * @ORM\Column(name="displayName", type="string", length=255)
     */
    private $displayName;

    /**
     * @var string
     *
     * @ORM\Column(name="parentPhone", type="string", length=255, nullable=true)
     */
    private $parentPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement", type="string", length=255, nullable=true)
     */
    private $etablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="branche", type="string", length=255, nullable=true)
     */
    private $branche;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;




           /**
     * Constructor
     */
    public function __construct($uid=null,$displayName=null,$email=null)
    {
        $this->studentId =$email;
        $this->uid =$uid;
        $this->displayName=$displayName;
    }


    /**
     * Set displayName
     *
     * @param string $displayName
     *
     * @return Candidat
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Get displayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set parentPhone
     *
     * @param string $parentPhone
     *
     * @return Candidat
     */
    public function setParentPhone($parentPhone)
    {
        $this->parentPhone = $parentPhone;

        return $this;
    }

    /**
     * Get parentPhone
     *
     * @return string
     */
    public function getParentPhone()
    {
        return $this->parentPhone;
    }

    /**
     * Set etablissement
     *
     * @param string $etablissement
     *
     * @return Candidat
     */
    public function setEtablissement($etablissement)
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * Get etablissement
     *
     * @return string
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Set branche
     *
     * @param string $branche
     *
     * @return Candidat
     */
    public function setBranche($branche)
    {
        $this->branche = $branche;

        return $this;
    }

    /**
     * Get branche
     *
     * @return string
     */
    public function getBranche()
    {
        return $this->branche;
    }

/**
     * Set studentId
     *
     * @param string $studentId
     *
     * @return Analyse
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;

        return $this;
    }

    /**
     * Get studentId
     *
     * @return string
     */
    public function getStudentId()
    {
        return $this->studentId;
    }
    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Candidat
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
     * Set email
     *
     * @param string $email
     *
     * @return Candidat
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}

