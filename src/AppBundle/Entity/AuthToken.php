<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="auth_tokens", uniqueConstraints={@ORM\UniqueConstraint(name="auth_tokens_value_unique", columns={"value"})})
 *  @ORM\Entity(repositoryClass="AppBundle\Repository\AuthTokenRepository") 
 */
class AuthToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $value;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean",nullable=true)
     */
    protected $enabled;
    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="authToken")
     */
    protected $user;


    static function create(User $user=null)
    {   
        $authToken = new AuthToken($user);
        return $authToken->setValue();
    }  


   public function __construct(User $user)
    {
        $this->user=$user;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
         return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue()
    {
        $this->value = $this->generatePIN();
       return $this->setCreatedAt(new \DateTime('now'));
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
         return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
         return $this;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
         return $this;
    }



   public function generatePIN($digits = 6){
    $i = 0; //counter
    $pin = ""; //our default pin is blank.
    while($i < $digits){
        //generate a random number between 0 and 9.
        $pin .= mt_rand(0, 9);
        $i++;
    }
    return $pin;
}
}