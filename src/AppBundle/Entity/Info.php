<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Info
 *
 * @ORM\Table(name="user_account_info")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoRepository")
  * @ORM\HasLifecycleCallbacks
 */
class Info
{


      /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="uid", type="string", length=255,  unique=true)
     */
    private $uid;

       /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(name="displayName", type="string", length=255, nullable=true)
     */
    private $displayName;


    /**
     * @var string
     *
     * @ORM\Column(name="photoURL", type="string", length=255, nullable=true)
     */
    private $photoURL;

    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=255, nullable=true)
     */
    private $langue;

    private $file;

    /**
   * @ORM\OneToOne(targetEntity="AppBundle\Entity\Candidat" , cascade={"persist", "remove"})
     @ORM\JoinColumn(name="candidat_id", referencedColumnName="studentId")
   */
    private $candidat;


    /**
     * Constructor
     */
    public function __construct($studentId=null)
    {
        $this->uid =$studentId;
    }


    /**
     * Set displayName
     *
     * @param string $displayName
     *
     * @return Info
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
     * Set email
     *
     * @param string $email
     *
     * @return Info
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

    /**
     * Set photoURL
     *
     * @param string $photoURL
     *
     * @return Info
     */
    public function setPhotoURL($photoURL)
    {
        $this->photoURL = $photoURL;

        return $this;
    }

    /**
     * Get photoURL
     *
     * @return string
     */
    public function getPhotoURL()
    {
        return $this->photoURL;
    }

    /**
     * Set langue
     *
     * @param string $langue
     *
     * @return Info
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return string
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * Set candidat
     *
     * @param \AppBundle\Entity\Candidat $candidat
     *
     * @return Info
     */
    public function setCandidat(\AppBundle\Entity\Candidat $candidat = null)
    {
        $this->candidat = $candidat;

        return $this;
    }

    /**
     * Get candidat
     *
     * @return \AppBundle\Entity\Candidat
     */
    public function getCandidat()
    {
        return $this->candidat;
    }
    
       public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
     $this->file = $file;
     return $this->file;
    }

    public function upload(){
       if(null === $this->getFile()){
                return false;
            }
                $oldFile = __DIR__.'/../../../web/uploads/images/'.$this->uid.'.jpg' ;
                if(file_exists($oldFile)){
                    unlink($oldFile);
                }
              $this->getFile()->move(
                __DIR__.'/../../../web/uploads/images/',
                $this->email.'.jpg'
                );
    return true;
    }

   public function getPath(){

            return __DIR__.'/../../../web/uploads/images/'.$this->uid.'.jpg';
    }
    public function remove(){

            if(file_exists($this->getPath())){
                unlink($this->getPath());
            }
    }
}
