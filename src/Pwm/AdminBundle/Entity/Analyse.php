<?php

namespace Pwm\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Session ;
use AppBundle\Entity\Matiere ;
use AppBundle\Entity\Partie ;
/**
 * Analyse
 *
 * @ORM\Table(name="resultat")
 * @ORM\Entity(repositoryClass="Pwm\AdminBundle\Repository\AnalyseRepository")
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
     * @var int
     *
     * @ORM\Column(name="gTime", type="integer", nullable=true)
     */
    private $time;


        /**
     * @var int
     *
     * @ORM\Column(name="failedNb", type="integer", nullable=true)
     */
    private $failedNb;

            /**
     * @var int
     *
     * @ORM\Column(name="trueNb", type="integer", nullable=true)
     */
    private $trueNb;


    private $dememe;

    private $rang;

    private $evalues;


    private $sup10;

        /**
     * @var int
     *
     * @ORM\Column(name="first_note", type="decimal", precision=10, scale=1, nullable=true)
     */
    private $firstNote;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="decimal", precision=10, scale=1, nullable=true)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="objectif", type="decimal", precision=10, scale=1, nullable=true)
     */
    private $objectif;

    /**
     * @var string
     *
     * @ORM\Column(name="programme", type="decimal", precision=10, scale=1, nullable=true)
     */
    private $programme;


     /**
      * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Session",inversedBy="analyses")
     */
    private $session;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Matiere")
   */
    private $matiere;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partie" )
   */
    private $partie;


    /**
   * @ORM\ManyToOne(targetEntity="Info" )
    * @ORM\JoinColumn(name="studentId",referencedColumnName="uid")
   */
    private $studentId;


     /**
     * @var string
     *
     * @ORM\Column(name="uid", type="string", length=255)
     */
    private $uid;

     /**
     * Constructor
     */
    public function __construct($studentId=null, Session $session = null, Matiere $matiere=null, Partie $partie=null)
    {
        $this->uid =$studentId;
        $this->partie=$partie;
         $this->matiere=$matiere;
        $this->session=$session;
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
     * Set matiere
     *
     * @param \Pwm\AdminBundle\Entity\Matiere $matiere
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
     * @return \Pwm\AdminBundle\Entity\Matiere
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * Set partie
     *
     * @param \Pwm\AdminBundle\Entity\Partie $partie
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
     * @return \Pwm\AdminBundle\Entity\Partie
     */
    public function getPartie()
    {
        return $this->partie;
    }

    /**
     * Set time
     *
     * @param integer $time
     *
     * @return Analyse
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return integer
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set failedNb
     *
     * @param integer $failedNb
     *
     * @return Analyse
     */
    public function setFailedNb($failedNb)
    {
        $this->failedNb = $failedNb;

        return $this;
    }
    /**
     * Set failedNb
     *
     * @param integer $failedNb
     *
     * @return Analyse
     */
    public function setEvalues($evalues)
    {
        $this->evalues = $evalues;

        return $this;
    }

       /**
     * Get failedNb
     *
     * @return integer
     */
    public function getEvalues()
    {
        return $this->evalues;
    }
    /**
     * Get failedNb
     *
     * @return integer
     */
    public function getFailedNb()
    {
        return $this->failedNb;
    }

    /**
     * Set trueNb
     *
     * @param integer $trueNb
     *
     * @return Analyse
     */
    public function setTrueNb($trueNb)
    {
        $this->trueNb = $trueNb;

        return $this;
    }

    /**
     * Get trueNb
     *
     * @return integer
     */
    public function getTrueNb()
    {
        return $this->trueNb;
    }

    /**
     * Set firstNote
     *
     * @param string $firstNote
     *
     * @return Analyse
     */
    public function setFirstNote($firstNote)
    {
        $this->firstNote = $firstNote;

        return $this;
    }

    /**
     * Get firstNote
     *
     * @return string
     */
    public function getFirstNote()
    {
        return $this->firstNote;
    }

    /**
     * Set dememe
     *
     * @param integer $dememe
     *
     * @return Analyse
     */
    public function setDememe($dememe)
    {
        $this->dememe = $dememe;

        return $this;
    }

    /**
     * Get dememe
     *
     * @return integer
     */
    public function getDememe()
    {
        return $this->dememe;
    }

    /**
     * Set rang
     *
     * @param integer $rang
     *
     * @return Analyse
     */
    public function setRang($rang)
    {
        $this->rang = $rang;

        return $this;
    }

    /**
     * Get rang
     *
     * @return integer
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set sup10
     *
     * @param integer $sup10
     *
     * @return Analyse
     */
    public function setSup10($sup10)
    {
        $this->sup10 = $sup10;

        return $this;
    }

    /**
     * Get sup10
     *
     * @return integer
     */
    public function getSup10()
    {
        return $this->sup10;
    }

    /**
     * Set uid
     *
     * @param string $uid
     *
     * @return Analyse
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set session
     *
     * @param \AppBundle\Entity\Session $session
     *
     * @return Analyse
     */
    public function setSession(\AppBundle\Entity\Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return \AppBundle\Entity\Session
     */
    public function getSession()
    {
        return $this->session;
    }
}
