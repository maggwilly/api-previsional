<?php
// src/Sdz/BlogBundle/Bigbrother/MessagePostEvent.php
namespace AppBundle\Event;
use Symfony\Component\EventDispatcher\Event;
use AppBundle\Entity\Question;
class QuestionEvent extends Event
{

protected $question;
public function __construct(Question $question)
{
$this->question = $question;

} 

public function getQuestion()
{
return $this->question;
} 

}