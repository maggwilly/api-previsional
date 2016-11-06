<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
/**
 * CommandeClient
 *
 * @ORM\Table(name="commande_client")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeClientRepository")
 */
class CommandeClient implements JsonSerializable
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

   /**
   * @ORM\OneToMany(targetEntity="AppBundle\Entity\CommandeProduit", mappedBy="commandeClient", cascade={"persist","remove"})
   */
    private $commandesProduit;

    
     /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PointVente",inversedBy="commandesClient")
   * @ORM\JoinColumn(nullable=false)
   */
  
    private $pointVente;

     private $nomPointVente;

   

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
   * @ORM\JoinColumn(nullable=false)
   */
  


 public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'date' => $this->getDate()->format(\DateTime::ISO8601),
            'status' => $this->getStatus(),
            'pointVente' => $this->pointVente->jsonSerialize()
            
        ];
    }

    private $user;

        /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status; //canceled, sended, payed, initialized
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return CommandeClient
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
     * Constructor
     */
    public function __construct()
    {
        $this->commandesProduit = new \Doctrine\Common\Collections\ArrayCollection();
    }

	 /**
     * Set status
     *
     * @param string $status
     * @return Commande
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
     * Add commandesProduit
     *
     * @param \AppBundle\Entity\CommandeProduit $commandesProduit
     * @return CommandeClient
     */
    public function addCommandesProduit(\AppBundle\Entity\CommandeProduit $commandesProduit)
    {
        $this->commandesProduit[] = $commandesProduit;

       $commandesProduit->setCommandeClient($this);
        return $this;
    }

    /**
     * Remove commandesProduit
     *
     * @param \AppBundle\Entity\CommandeProduit $commandesProduit
     */
    public function removeCommandesProduit(\AppBundle\Entity\CommandeProduit $commandesProduit)
    {
        $this->commandesProduit->removeElement($commandesProduit);
    }

    /**
     * Get commandesProduit
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommandesProduit()
    {
        return $this->commandesProduit;
    }

    /**
     * Set pointVente
     *
     * @param \AppBundle\Entity\PointVente $pointVente
     * @return CommandeClient
     */
    public function setPointVente(\AppBundle\Entity\PointVente $pointVente)
    {
        $this->pointVente = $pointVente;

        return $this;
    }

    /**
     * Get pointVente
     *
     * @return \AppBundle\Entity\PointVente 
     */
    public function getPointVente()
    {
        return $this->pointVente;
    }



    public function setNomPointVente($pointVente)
    {
        $this->nomPointVente = $pointVente;

        return $this;
    }

 
    public function getNomPointVente()
    {
        return $this->nomPointVente;
    }
    /**
     * Set journee
     *
     * @param \AppBundle\Entity\Journee $journee
     * @return CommandeClient
     */
    public function setJournee(\AppBundle\Entity\Journee $journee)
    {
        $this->journee = $journee;

        return $this;
    }

    /**
     * Get journee
     *
     * @return \AppBundle\Entity\Journee 
     */
    public function getJournee()
    {
        return $this->journee;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Client $user
     * @return CommandeClient
     */
    public function setUser(\AppBundle\Entity\Client $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\Client 
     */
    public function getUser()
    {
        return $this->user;
    }
}
