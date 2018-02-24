<?php
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
protected $twig;
const HEADERS=array(
    "Authorization: key=AAAAJiQu4xo:APA91bH63R7-CeJ7jEgGtb2TNVkCx0TDWAYbu32mO1_4baLtrrFidNrbNy98Qngb6G67efbuJ8BpInpJiCeoTp-p5mt2706P2hXbXqrTXOWlaJFTDHza2QVWSlwsbF27eBhD2PZVJKuu",
    "content-type: application/json"
  );
const FCM_URL = "https://fcm.googleapis.com/fcm/send";
 
public function __construct(CloudinaryWrapper $cloudinaryWrapper,EntityManager $_em,\Twig_Environment $templating)
{

$this->cloudinaryWrapper = $cloudinaryWrapper;
$this->_em=$_em;
$this->twig=$templating;
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

public function onRegistration(RegistrationEvent $event)
{
     $registrations= array($event->getRegistration());
     $info=$registrations->getInfo();
     $notification = $this->_em->getRepository('MessagerBundle:Notification')->findOneByTag('welcome_message');
      $registrationIds=$this->sendTo($registrations, $notification);
      $this->firebaseSend($registrationIds, $notification); 
      if($info!=null){
        $url="https://trainings-fa73e.firebaseio.com/users/".$info->getUid()."/registrationsId/.json";
        $data = array($registrations->getRegistrationId() => true);
         $this->sendPostRequest($url,$data);
     } 
}



public function onCommandeConfirmed(CommandeEvent $event)
{
   $commande=$event->getCommande();
    $info= $commande->getInfo();
    $notification=new Notification('private');
    $body = $this->renderTemplate($commande);
     if ($commande->getStatus()=='SUCCESS') {
       $notification->setTitre($commande-> getSession()->getNomConcours())->setSousTitre($commande-> getSession()->getNomConcours())
     ->setText($body);
      $registrationIds=$this->sendTo($info->getRegistrations(), $notification);
      $this->firebaseSend($registrationIds, $notification); 
    }
      if ($info!=null) {
        $url="https://trainings-fa73e.firebaseio.com/session/".$commande-> getSession()->getId()."/members/.json";
        $data = array($info->getUid() => true);
         $this->sendPostRequest($url,$data);
        }
}

     /**
     * Displays a form to edit an existing notification entity.
     *
     */
    public function sendTo($registrations,Notification $notification)
    {
   // $registrationIds='';
      $registrationIds=array();
   foreach ($registrations as $registration) {
   // $registrationIds=$registrationIds.'"'.$registration->getRegistrationId().'", ';
    $registrationIds[]=$registration->getRegistrationId();
        $sending=new Sending($registration,$notification);
          $this->_em->persist($sending);  
       }
      $this->_em->flush();
     return  $registrationIds;
    }


public function firebaseSend($registrationIds, Notification $notification ){
$data=array(
        'registration_ids' => array_values($registrationIds),
        'title' => $notification->getTitre(),
        'body' => $notification->getSousTitre(),
        'badge' => 1,
        'tag' => 'confirm',
        'data' => array(
               'action' => "new_message"
        )
    );

  return $this->sendPostRequest(self::FCM_URL,$data,self::HEADERS);      
}

    public function renderTemplate(\Pwm\AdminBundle\Entity\Commande $commande)
    {
        return $this->twig->render(
            'MessagerBundle:notification:confirmation.html.twig',
            array(
                'commande' => $commande
            )
        );
    }


  public function sendPostRequest($url,$data,$headers=array(),$json_decode=true)
    {
        $content = json_encode($data);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ( $status != 200 ) {}
        curl_close($curl);
        $response = json_decode($json_response, true);
        return $response;
    }

}