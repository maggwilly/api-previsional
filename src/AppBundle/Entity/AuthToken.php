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
     * @ORM\ManyToOne(targetEntity="User")
     * @var User
     */
    protected $user;

   public function __construct()
    {
    }
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
         return $this;
    }

    static function create(User $user)
    {   
        $authToken = new AuthToken();
       
        $authToken->setValue($authToken->generatePIN());
        $authToken->setCreatedAt(new \DateTime('now'));
        $authToken->setUser($user);
        return  $authToken;
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