<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rapport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Rapport controller.
 *
 */
class RapportController extends Controller
{
    /**
     * Lists all rapport entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rapports = $em->getRepository('AppBundle:Rapport')->findAll();

        return $this->render('rapport/index.html.twig', array(
            'rapports' => $rapports,
        ));
    }

    /**
     * @Rest\View(serializerGroups={"rapport"})
     * 
     */
    public function indexJsonAction(Request $request)
    {
           $keys=$request->query->get('keys');
         if (count_chars($keys)>0) {
             $keys=explode(".", $keys);
         }else $keys=[0];
        $em = $this->getDoctrine()->getManager();
         $user=$this->getUser();
        $rapports = $em->getRepository('AppBundle:Rapport')->findByUser($user,0,null,$keys);
        return $rapports;
    }

    /**
     * @Rest\View()
     * 
     */
    public function statsJsonAction(Request $request)
    {
     $alls=$request->query->all();
     $em=$this->getDoctrine()->getManager();
    $previsioner=$this->get('previsonal_client');
     $week=[];
     $newClientCount=0;// engagés
     $prospectCount=0; //prospets réalisés
     $visiedCount=0; // livraison réalisés
     $visitedCountTarget=0;// livraison prévus

     $colisSumTarget=0;// colis prévus
     $caSumTarget=0;// ca target

     $colisSum=0; //colis réalisés
     $caSum=0;// Ca réalisé
     $pointVentes =new ArrayCollection($em->getRepository('AppBundle:PointVente')->findByUser($this->getUser(),$alls,[""],true));

     $pointVentes->map(function($entry)
      use (
        $alls,
        &$prospectCount,
        &$newClientCount,
        &$week,
        &$visiedCount,
        &$visitedCountTarget,
        &$colisSum,
        &$caSum,
        &$colisSumTarget,
        &$caSumTarget,
        $previsioner){
         if(array_key_exists('afterdate',$alls))
              $startDate=new \DateTime($alls['afterdate']);
         if(array_key_exists('beforedate',$alls))
             $endDate=new \DateTime($alls['beforedate']);
           $engagement=$previsioner->findFirstCommende($entry);
          if(($engagement!=null)&&($engagement->getDate()>=$startDate)&&($engagement->getDate()<=$endDate)){
            if(!array_key_exists($engagement->getWeek(),$week))
                $week[$engagement->getWeek()]=['created'=>0,'engaged'=>0,'visitedtarget'=>0,'visited'=>0,'colistarget'=>0,'catarget'=>0,'colis'=>0,'ca'=>0];
                $week[$engagement->getWeek()]['engaged']++;
                $newClientCount++; 
          }

      if($entry->getDate()&&( $entry->getDate()>=$startDate)
        &&($entry->getDate()<=$endDate)
        &&(!array_key_exists('doneBy',$alls)
            ||array_key_exists('doneBy',$alls)&&$entry->getCreatedBy()&&$entry->getCreatedBy()->getId()==$alls['doneBy'])){
            if(!array_key_exists($entry->getWeek(),$week))
                 $week[$entry->getWeek()]=['created'=>0,'engaged'=>0,'visitedtarget'=>0,'visited'=>0,'colistarget'=>0,'catarget'=>0,'colis'=>0,'ca'=>0];
                 $week[$entry->getWeek()]['created']++;
                 $prospectCount++;
          }
          if($engagement!=null){
             $commendes=$previsioner->getCommendes(null,$entry,$alls);
             foreach ($commendes as $key => $commende) {
              if(!array_key_exists($commende->getWeek(),$week))
                    $week[$commende->getWeek()]=['created'=>0,'engaged'=>0,'visitedtarget'=>0,'visited'=>0,'colistarget'=>0,'catarget'=>0,'colis'=>0,'ca'=>0];
                 $week[$commende->getWeek()]['colis']+=$commende->getColisSum();
                 $week[$commende->getWeek()]['ca']+=$commende->getCaSum();
                 $week[$commende->getWeek()]['visited']++;
                 $colisSum+=$commende->getColisSum();
                 $caSum+=$commende->getCaSum();
                 $visiedCount++;
             }
           }
             $rendezvouss=$previsioner->getRendezvouss($entry,$alls);
            foreach ($rendezvouss as $key => &$rendezvous) {
                 $rendezvous=$previsioner->addPrevisions($rendezvous,false);
              if(!array_key_exists($rendezvous->getWeek(),$week))
              $week[$rendezvous->getWeek()]=['created'=>0,'engaged'=>0,'visitedtarget'=>0,'visited'=>0,'colistarget'=>0,'catarget'=>0,'colis'=>0,'ca'=>0];
                 $week[$rendezvous->getWeek()]['colistarget']+=$rendezvous->getColisSum();
                 $colisSumTarget+=$rendezvous->getColisSum();
                 $week[$rendezvous->getWeek()]['catarget']+=$rendezvous->getCaSum();
                  $caSumTarget+=$rendezvous->getCaSum();

                 $week[$rendezvous->getWeek()]['visitedtarget']++;
                 $visitedCountTarget++;
             } 
         return   $entry;        
     });

      if(!empty($week)){
         $keys = array_keys($week);
         sort($keys);

         for ($i=(int)$keys[0]; $i <(int)$keys[count($keys)-1] ; $i++) { 
             if(!array_key_exists(''.$i, $week))
                $week[''.$i]=['created'=>0,'engaged'=>0,'visited'=>0,'visitedtarget'=>0,'colistarget'=>0,'catarget'=>0,'colis'=>0,'ca'=>0];
         }
       ksort($week);
       foreach ($week as $key => $value) {
              $date=new \DateTime($alls['afterdate']);
             $keyLong=($date->setISODate(date('Y'), $key))->format('d/m/y').' - '.($date->setISODate(date('Y'), $key,7))->format('d/m/y');
              // $value['week']=$keyLong;
               $week[$keyLong]= $value;
              unset($week[$key]);
       }
     }
        return array(
            'id'=>'sale-satat',
            'total_count'=>count($pointVentes),
            'colis_count'=> $colisSum,
            'ca_sum'=> $caSum,
            'colis_target'=> $colisSumTarget,
            'ca_starget'=> $caSumTarget,
            'created_count'=> $prospectCount,
            'engaged_count'=> $newClientCount,
            'visited_count'=> $visiedCount,
            'visited_count_target'=> $visitedCountTarget,
            'target_vs_visited'=> $visitedCountTarget>0?ceil($visiedCount*100/$visitedCountTarget):'?',
             'weeks'=>  $week
        );
    }


    /**
     * @Rest\View(serializerGroups={"map"})
     * 
     */
    public function mapJsonAction(Request $request)
    {
     $alls=$request->query->all();
     $em=$this->getDoctrine()->getManager();
 $pointVentes =new ArrayCollection($em->getRepository('AppBundle:PointVente')->findByUser($this->getUser(),$alls,[""],true));
 $pointVentes->map(function($entry)  use ($alls){
         $previsioner=$this->get('previsonal_client');
         if(array_key_exists('afterdate',$alls))
              $startDate=new \DateTime($alls['afterdate']);
         if(array_key_exists('beforedate',$alls))
             $endDate=new \DateTime($alls['beforedate']);

             $commendes=$previsioner->getCommendes(null,$entry,$alls);
             $rendezvouss=$previsioner->getRendezvouss($entry,$alls);    
            if(count($commendes)>=count($rendezvouss))
              $entry->setVisited(2);
            elseif (count($rendezvouss)>0&&ceil(count($commendes)*100/count($rendezvouss))>=55)
              $entry->setVisited(1); # code...
             else
              $entry->setVisited(0);
       $entry->setRendezvous($previsioner->findNextRendevous($entry));
         return  $entry;    
     });

        return $pointVentes;
    }

    /**
     * @Rest\View(serializerGroups={"prevision"})
     */
    public function previsionsJsonAction(Request $request)
    {   
        $alls=$request->query->all();
        $keys=$request->query->has('keys')?$request->query->get('keys'):'';
         if (count_chars($keys)>0) {
              $keys=explode(".", $keys);
         }else $keys=[""]; 
          $previsioner=$this->get('previsonal_client');
          $lesprevisions=[];    
         (new ArrayCollection($this->getDoctrine()->getManager()->getRepository('AppBundle:PointVente')->findByUser($this->getUser(),$alls,$keys,true)))->map(function($pointVente) use (&$lesprevisions,$previsioner,$alls){
             $rendezvous=$previsioner->findLastRendevous($pointVente,null,$alls);
              if($rendezvous)
                foreach ($previsioner->getPrevisions($rendezvous) as $key => $previsions) {
                 if (!array_key_exists($previsions['id'], $lesprevisions)&&array_key_exists('next_cmd_quantity',$previsions)){ $lesprevisions[$previsions['id']]=$previsions;
                      $lesprevisions[$previsions['id']]['next_cmd_clients']=[
                                    array("pointVente"=>$pointVente,
                                    'quantity'=>$previsions['next_cmd_quantity'],
                                    'dateat'=>$previsions['next_cmd_date']
                                )
                              ];
                      continue; 
                    }
                      if(array_key_exists('next_cmd_quantity', $previsions)){
                               $lesprevisions[$previsions['id']]['next_cmd_quantity']+=$previsions['next_cmd_quantity'];
                               $lesprevisions[$previsions['id']]['next_cmd_cost']+=$previsions['next_cmd_cost'];
                               if($lesprevisions[$previsions['id']]['next_cmd_date']>$previsions['next_cmd_date'])
                                $lesprevisions[$previsions['id']]['next_cmd_date']=$previsions['next_cmd_date'];
                                $lesprevisions[$previsions['id']]['next_cmd_clients'][]=array("pointVente"=>$pointVente,
                                    'quantity'=>$previsions['next_cmd_quantity'],
                                    'dateat'=>$previsions['next_cmd_date']
                                );
                            }
                }
            return;     
         });      
        return array_values($lesprevisions) ;
    }
    /**
     * Finds and displays a rapport entity.
     */
    public function showAction(Rapport $rapport)
    {
        return $this->render('rapport/show.html.twig', array(
            'rapport' => $rapport,
        ));
    }


     public function getMobileUser(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
          $user = $em->getRepository('AppBundle:User')->findOneById($request->headers->get('X-User-Id'));
        return $user;
    }     
}
