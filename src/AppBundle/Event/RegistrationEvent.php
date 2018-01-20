<?php
namespace AppBundle\Event;
use Symfony\Component\EventDispatcher\Event;
use Pwm\MessagerBundle\Entity\Registration;
class RegistrationEvent extends Event
{

protected $info;
public function __construct(Registration $registration)
{
$this->registration = $registration;

} 

public function getRegistration()
{
return $this->registration;
} 

}