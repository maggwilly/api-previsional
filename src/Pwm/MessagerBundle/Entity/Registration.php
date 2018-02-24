<?php

namespace Pwm\MessagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Registration
 *
 * @ORM\Table(name="registration")
 * @ORM\Entity(repositoryClass="Pwm\MessagerBundle\Repository\RegistrationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Registration
{

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=255, unique=true)
     * @ORM\Id
     */
    private $registrationId;


    /**
     * @var string
     *
     * @ORM\Column(name="user_agent", type="string", length=255, nullable=true)
     */
    private $userAgent;

        /**
     * @var string
     *
     * @ORM\Column(name="app_version", type="string", length=255, nullable=true)
     */
    private $appVersion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

        /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login_date", type="datetime", nullable=true)
     */
    private $latLoginDate;

     /**
   * @ORM\ManyToOne(targetEntity="Pwm\AdminBundle\Entity\Info", inversedBy="registrations", cascade={"persist"})
   * @ORM\JoinColumn(referencedColumnName="uid")
   */
     private  $info;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date =new \DateTime();  
        $this->latLoginDate =new \DateTime();    
    }


    /**
    * @ORM\PostUpdate()
    */
    public function PostPersist(){
     if($this->info!=null){
        $url="https://trainings-fa73e.firebaseio.com/users/".$this->$info->getUid()."/registrationsId/.json";
        $data = array($this->registrationId => true);
         $this->sendPostRequest($url,$data);
     }
        //create inscrir au groupe
    } 



    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Registration
     */
    public function setUserAgent($date)
    {
        $this->userAgent = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set registrationId
     *
     * @param string $registrationId
     *
     * @return Registration
     */
    public function setRegistrationId($registrationId)
    {
        $this->registrationId = $registrationId;

        return $this;
    }

    /**
     * Get registrationId
     *
     * @return string
     */
    public function getRegistrationId()
    {
        return $this->registrationId;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Registration
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set info
     *
     * @param \Pwm\AdminBundle\Entity\Info $info
     *
     * @return Registration
     */
    public function setInfo(\Pwm\AdminBundle\Entity\Info $info = null)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return \Pwm\AdminBundle\Entity\Info
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set latLoginDate
     *
     * @param \DateTime $latLoginDate
     *
     * @return Registration
     */
    public function setLatLoginDate($latLoginDate)
    {
        $this->latLoginDate = $latLoginDate;

        return $this;
    }

    /**
     * Get latLoginDate
     *
     * @return \DateTime
     */
    public function getLatLoginDate()
    {
        return $this->latLoginDate;
    }

  public function sendPostRequest($url,$data,$headers=array(),$json_decode=true)
    {
        $content = json_encode($data);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($curl, CURLOPT_PATCH , true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST , "PATCH");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
         curl_close($curl);
       if ($err) {
            $json_err = json_decode($err, true);
            return $json_decode?$json_err:$err;
        }
        $response = json_decode($json_response, true);
        return $json_decode?$response:$json_response;
    }

}
