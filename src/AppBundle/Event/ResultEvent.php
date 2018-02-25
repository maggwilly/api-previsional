<?php
namespace AppBundle\Event;
use Symfony\Component\EventDispatcher\Event;

class ResultEvent extends Event
{

protected $resultats;
protected $descs;
public function __construct($descs,$resultats)
{
$this->resultats = $resultats;
$this->descs = $descs;
} 

public function getFCMResult()
{
return $this->resultats;
} 

public function getFCMDescsTokens()
{
return $this->descs;
}
}