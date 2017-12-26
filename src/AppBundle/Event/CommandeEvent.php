<?php
// src/Sdz/BlogBundle/Bigbrother/MessagePostEvent.php
namespace AppBundle\Event;
use Symfony\Component\EventDispatcher\Event;
use Pwm\AdminBundle\Entity\Commande;
class CommandeEvent extends Event
{

protected $commande;

public function __construct(Commande $commande)
{
$this->commande = $commande;
} 

public function getCommande()
{
return $this->commande;
} 

}