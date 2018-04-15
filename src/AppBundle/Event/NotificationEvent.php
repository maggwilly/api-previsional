<?php
namespace AppBundle\Event;
use Symfony\Component\EventDispatcher\Event;
use Pwm\MessagerBundle\Entity\Notification;
class NotificationEvent extends Event
{

protected $notifcation;
protected $descs;
protected $data;
public function __construct($descs,Notification $notifcation,$data=array())
{
$this->notifcation = $notifcation;
$this->descs = $descs;
$this->data = $data;
} 

public function getNotification()
{
return $this->notifcation;
} 

public function getDescs()
{
return $this->descs;
}
public function getData()
{
return $this->data;
}
}