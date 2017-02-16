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
     * @ORM\ManyToOne(targetEntity="Client")
     * @var User
     */
    protected $user;


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

    public function setUser(Client $user)
    {
        $this->user = $user;
    }

    static function create(Client $user)
    {   
        $authToken = new AuthToken();
        $str = uniqid();
        $authToken->setValue(md5($str));
        $authToken->setCreatedAt(new \DateTime('now'));
        $authToken->setUser($user);
        return  $authToken;
    }  
}