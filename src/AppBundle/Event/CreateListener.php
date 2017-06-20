<?php
// src/Sdz/BlogBundle/Bigbrother/CensureListener.php
namespace AppBundle\Event;
use Symfony\Component\EventDispatcher\Event;
use Misteio\CloudinaryBundle\Wrapper\CloudinaryWrapper;
use Doctrine\ORM\EntityManager;
class CreateListener
{
// Liste des id des utilisateurs à surveiller

protected $cloudinaryWrapper;
protected $_em;
public function __construct(CloudinaryWrapper $cloudinaryWrapper,EntityManager $_em)
{

$this->cloudinaryWrapper = $cloudinaryWrapper;
$this->_em=$_em;
}

public function onObjetCreated(QuestionEvent $event)
{
     $question=$event->getQuestion();
     $image=$question->getImageEntity();
     if($image!=null){
       if( $image->upload()){
         $results=  $this->cloudinaryWrapper-> upload($image->getPath(), '_question_'.$question->getId())->getResult();
         $image->setUrl($results['url']);
          $this->_em->flush();
          $image->remove();
       }
     }
}


 

}