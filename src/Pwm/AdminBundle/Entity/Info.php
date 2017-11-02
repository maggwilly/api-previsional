<?php

namespace Pwm\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Info
 *
 * @ORM\Table(name="user_account_details")
 * @ORM\Entity(repositoryClass="Pwm\AdminBundle\Repository\InfoRepository")
  * @ORM\HasLifecycleCallbacks
 */
class Info
{
        /**
     * @var string
    * @ORM\Id
     * @ORM\Column(name="uid", type="string", length=255)
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

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;


    /**
     * @var string
     *
     * @ORM\Column(name="branche", type="string", length=255, nullable=true)
     */
    private $branche;


    /**
     * @var string
     *
     * @ORM\Column(name="payment_method", type="string", length=255, nullable=true)
     */
    private $paymentMethod;


    /**
     * @var string
     *
     * @ORM\Column(name="enable_notifications", type="boolean", nullable=true)
     */
    private $enableNotifications;

    private $file;




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

    /**
     * Set uid
     *
     * @param string $uid
     *
     * @return Info
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
     * Set phone
     *
     * @param string $phone
     *
     * @return Info
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Info
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
     * Set branche
     *
     * @param string $branche
     *
     * @return Info
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
     * Set paymentMethod
     *
     * @param string $paymentMethod
     *
     * @return Info
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set enableNotifications
     *
     * @param boolean $enableNotifications
     *
     * @return Info
     */
    public function setEnableNotifications($enableNotifications)
    {
        $this->enableNotifications = $enableNotifications;

        return $this;
    }

    /**
     * Get enableNotifications
     *
     * @return boolean
     */
    public function getEnableNotifications()
    {
        return $this->enableNotifications;
    }
}
