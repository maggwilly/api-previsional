<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Analyse
 *
 * @ORM\Table(name="analyse")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnalyseRepository")
 */
class Analyse
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
     * @ORM\Column(name="note", type="decimal", precision=10, scale=4, nullable=true)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="objectif", type="decimal", precision=10, scale=4, nullable=true)
     */
    private $objectif;

    /**
     * @var string
     *
     * @ORM\Column(name="programme", type="decimal", precision=10, scale=4, nullable=true)
     */
    private $programme;


       /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Programme" )
   */
    private $concours;

       /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Matiere")
   */
    private $matiere;

       /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partie" )
   */
    private $partie;

      /**
     * @var string
     *
     * @ORM\Column(name="studentId", type="string", length=255)
     */
    private $studentId;



        /**
     * Constructor
     */
    public function __construct($studentId=null, Programme $concours, Matiere $matiere=null, Partie $partie=null)
    {
        $this->studentId =$studentId;
        $this->partie=$partie;
         $this->matiere=$matiere;
        $this->concours=$concours;
    }
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
     * Set note
     *
     * @param string $note
     *
     * @return Analyse
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set objectif
     *
     * @param string $objectif
     *
     * @return Analyse
     */
    public function setObjectif($objectif)
    {
        $this->objectif = $objectif;

        return $this;
    }

    /**
     * Get objectif
     *
     * @return string
     */
    public function getObjectif()
    {
        return $this->objectif;
    }

    /**
     * Set programme
     *
     * @param string $programme
     *
     * @return Analyse
     */
    public function setProgramme($programme)
    {
        $this->programme = $programme;

        return $this;
    }

    /**
     * Get programme
     *
     * @return string
     */
    public function getProgramme()
    {
        return $this->programme;
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
     * Set concours
     *
     * @param \AppBundle\Entity\Programme $concours
     *
     * @return Analyse
     */
    public function setConcours(\AppBundle\Entity\Programme $concours = null)
    {
        $this->concours = $concours;

        return $this;
    }

    /**
     * Get concours
     *
     * @return \AppBundle\Entity\Programme
     */
    public function getConcours()
    {
        return $this->concours;
    }

    /**
     * Set matiere
     *
     * @param \AppBundle\Entity\Matiere $matiere
     *
     * @return Analyse
     */
    public function setMatiere(\AppBundle\Entity\Matiere $matiere = null)
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return \AppBundle\Entity\Matiere
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * Set partie
     *
     * @param \AppBundle\Entity\Partie $partie
     *
     * @return Analyse
     */
    public function setPartie(\AppBundle\Entity\Partie $partie = null)
    {
        $this->partie = $partie;

        return $this;
    }

    /**
     * Get partie
     *
     * @return \AppBundle\Entity\Partie
     */
    public function getPartie()
    {
        return $this->partie;
    }
}
