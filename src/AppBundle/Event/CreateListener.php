<?php
namespace AppBundle\Event;
use Symfony\Component\EventDispatcher\Event;
use Misteio\CloudinaryBundle\Wrapper\CloudinaryWrapper;
use Pwm\MessagerBundle\Entity\Notification;
use Pwm\MessagerBundle\Entity\Sending;
use AppBundle\Service\FMCManager;
use Doctrine\ORM\EntityManager;
class CreateListener
{
// Liste des id des utilisateurs à surveiller

protected $cloudinaryWrapper;
protected $_em;
protected $twig;
protected $fcm;
const HEADERS=array(
    "Authorization: key=AAAAJiQu4xo:APA91bH63R7-CeJ7jEgGtb2TNVkCx0TDWAYbu32mO1_4baLtrrFidNrbNy98Qngb6G67efbuJ8BpInpJiCeoTp-p5mt2706P2hXbXqrTXOWlaJFTDHza2QVWSlwsbF27eBhD2PZVJKuu",
    "content-type: application/json"
  );
const FCM_URL = "https://fcm.googleapis.com/fcm/send";
 
public function __construct(CloudinaryWrapper $cloudinaryWrapper,EntityManager $_em,\Twig_Environment $templating,FMCManager $fcm)
{

$this->cloudinaryWrapper = $cloudinaryWrapper;
$this->_em=$_em;
$this->twig=$templating;
$this->fcm=$fcm;
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
     $info=$event->getRegistration()->getInfo();
     $notification = $this->_em->getRepository('MessagerBundle:Notification')->findOneByTag('welcome_message');
      $registrationIds=$this->sendTo($registrations, $notification);
      $this->firebaseSend($registrationIds, $notification); 
      if($info!=null){
        $url="https://trainings-fa73e.firebaseio.com/users/".$info->getUid()."/registrationsId/.json";
        $data = array($registrations->getRegistrationId() => true);
        $this->fcm->sendOrGetData($url,$data,'PATCH');
     } 
}



public function onCommandeConfirmed(CommandeEvent $event)
{
   $commande=$event->getCommande();
    $info= $commande->getInfo();
    $notification=new Notification('private');
    $body =  $this->twig->render('MessagerBundle:notification:confirmation.html.twig',  array('commande' => $commande ));
     if ($commande->getStatus()=='SUCCESS') {
       $notification->setTitre($commande-> getSession()->getNomConcours())->setSousTitre($commande-> getSession()->getNomConcours())
     ->setText($body);
      $this->firebaseSend($this->sendTo($info->getRegistrations(), $notification), $notification); 
     }
      if ($info!=null) {
        $url="https://trainings-fa73e.firebaseio.com/session/".$commande-> getSession()->getId()."/members/.json";
        $data = array($info->getUid() => true);
        $this->fcm->sendOrGetData($url,$data,'PATCH');
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
    if (!$registration->getIsFake()) {
     $registrationIds[]=$registration->getRegistrationId();
        $sending=new Sending($registration,$notification);
          $this->_em->persist($sending);
      }
   
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

  return $this->fcm->sendMessage($data);
}


public function onMessageEnd(ResultEvent $event)
{
     $fcmResult= $event->getFCMResult();
     $descTokens= $event->getFCMDescsTokens();
     $this->removeFakesTokens($fcmResult,$descTokens);
}

 public function  removeFakesTokens($fcmResult,$descTokens){

        foreach ($descTokens as $key => $registrationId) {
                if(array_key_exists('error', $fcmResult[$key])){
                    $registration=$this->_em->getRepository('MessagerBundle:Registration')->findOneByRegistrationId($registrationId);
                    $registration->setIsFake(true);
                }
                 $registration->setLastControlDate(new \DateTime());
        }
           $this->_em->flush();
     }


}