<?php
// src/Sdz/BlogBundle/Bigbrother/CensureListener.php
namespace AppBundle\Event;
use Symfony\Component\EventDispatcher\Event;
use Misteio\CloudinaryBundle\Wrapper\CloudinaryWrapper;
use Pwm\MessagerBundle\Entity\Notification;
use Pwm\MessagerBundle\Entity\Sending;
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
          $info->remove();
       }
     
}

public function onCommandeConfirmed(InfoEvent $event)
{
    $info=$event->getInfo();
    $notification=new Notification('private');
    $notification->setTitre('Inscription validée')->setSousTitre('Inscription prise en compte')->setText('Votre inscription a été prise en compte.');
    $registrationIds=$this->sendTo($info->getRegistrations(), $notification);
    $this->firebaseSend($registrationIds, $notification); 
}

     /**
     * Displays a form to edit an existing notification entity.
     *
     */
    public function sendTo($registrations,Notification $notification)
    {
   
    $registrationIds='';
   foreach ($registrations as $registration) {
    $registrationIds=$registrationIds.'"'.$registration->getRegistrationId().'", ';
        $sending=new Sending($registration,$notification);
          $this->_em->persist($sending);  
       }
      $this->_em->flush();
     return  $registrationIds;
    }


public function firebaseSend($registrationIds,Notification $notification ){
 //   $registrationIds = array_values($registrationIds);
    $data="{\"registration_ids\":[".$registrationIds."], \"notification\":{\"title\":\"".$notification->getTitre()."\",\"body\":\"".$notification->getText()."\",\"subtitle\":\"".$notification->getSousTitre()."\",\"tag\":\"tag\"}}";
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 120,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>$data ,
  CURLOPT_HTTPHEADER => array(
    "Authorization: key=AAAAJiQu4xo:APA91bH63R7-CeJ7jEgGtb2TNVkCx0TDWAYbu32mO1_4baLtrrFidNrbNy98Qngb6G67efbuJ8BpInpJiCeoTp-p5mt2706P2hXbXqrTXOWlaJFTDHza2QVWSlwsbF27eBhD2PZVJKuu",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
  return  $err;
} 
  return $response;
        
}


}