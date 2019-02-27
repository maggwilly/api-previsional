<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Request
 *
 * @ORM\Table(name="request")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RequestRepository")
 */
class Request
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
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

        /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",inversedBy="receiveRequests", cascade={"persist"})
     * @var User
     */
    protected $user;

     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",inversedBy="sendRequests")
     * @var User
     */
    protected $parent;

    protected $username;


    /**
     * @var string
     * @ORM\Column(name="object", type="string", length=255, nullable=true)
     */
    private $object;

   public function __construct(User $parent,User $user=null)
    {
     $this->date=new \DateTime();
      $this->parent = $parent;
      $this->user = $user;

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
     * Set status
     *
     * @param string $status
     *
     * @return Request
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Request
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
     * Set object
     *
     * @param string $object
     *
     * @return Request
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    public function getUsername()
    {
        return $this->username;
    } 


    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }  

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Request
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\User $parent
     *
     * @return Request
     */
    public function setParent(\AppBundle\Entity\User $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\User
     */
    public function getParent()
    {
        return $this->parent;
    }
}
