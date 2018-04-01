<?php
namespace AppBundle\Event;
use Symfony\Component\EventDispatcher\Event;
use Pwm\MessagerBundle\Entity\Notification;
class NotificationEvent extends Event
{

protected $notifcation;
protected $descs;
public function __construct($descs,Notification $notifcation)
{
$this->notifcation = $notifcation;
$this->descs = $descs;
} 

public function getNotification()
{
return $this->notifcation;
} 

public function getDescs()
{
return $this->descs;
}
}