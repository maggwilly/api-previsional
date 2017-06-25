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
         $results=  $this->cloudinaryWrapper-> upload($image->getPath(), '_question_'.$question->getId(),array(), array("crop" => "limit","width" => "200", "height" => "150"))->getResult();
         $image->setUrl($results['url']);
          $this->_em->flush();
          $image->remove();
       }
     }
}

public function onUserPictureSubmited(InfoEvent $event)
{
     $info=$event->getInfo();
       if( $info->upload()){
        $results=  $this->cloudinaryWrapper-> upload($info->getPath(), '_user_'.$info->getEmail(),array(), array("crop" => "limit","width" => "200", "height" => "150"))->getResult();
         $info->setPhotoURL($results['url']);
          $this->_em->flush();
          $$info->remove();
       }
     
}


 
 

}