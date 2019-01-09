<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Etape controller.
 *
 */
class AppController extends Controller
{
    /**
     * Lists all etape entities.
     *
     */
    public function indexAction()
    {   
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31');

        $nombreCout = $em->getRepository('AppBundle:Souscripteur')->nombreCout($region,$startDate,$endDate);
        $performences = $em->getRepository('AppBundle:Souscripteur')->performances($region,$startDate,$endDate);
        $repartition = $em->getRepository('AppBundle:Souscripteur')->repartition($region,$startDate,$endDate);
        $evolutionByWeek = $em->getRepository('AppBundle:Souscripteur')->evolutionByWeek($region,$startDate,$endDate);
        $evolutionByMonth = $em->getRepository('AppBundle:Souscripteur')->evolutionByMonth($region,$startDate,$endDate);
        $especesByMonth = $em->getRepository('AppBundle:Souscripteur')->especesByMonth($region,$startDate,$endDate);

        return $this->render('AppBundle::index.html.twig', 
            array(
                'performences'=> $performences,
                'repartition'=> $repartition,
                'evolutionByWeek'=> $evolutionByWeek,
                'evolutionByMonth'=> $evolutionByMonth,
                 'especesByMonth'=> $especesByMonth,
                'nombre'=> $nombreCout[0]['nombre'],
                'cout'=> $nombreCout[0]['cout']
        ));
    }



    public function setPeriodeAction(Request $request)
    {
  
        $region=$request->request->get('region');
        $periode= $request->request->get('periode');
        $dates = explode(" - ", $periode);
        $startDate=$dates[0];
        $endDate=$dates[1];
        $format = 'd/m/Y';
        $startDate= \DateTime::createFromFormat($format, $dates[0]);
        $endDate= \DateTime::createFromFormat($format, $dates[1]);
        $session = $this->getRequest()->getSession();
        $session->set('region',$region);
        $session->set('startDate',$startDate->format('Y-m-d'));
        $session->set('endDate',$endDate->format('Y-m-d'));
        $session->set('periode',$periode);
        $session->set('end_date_formated',$endDate->format('d/m/Y'));
        $session->set('start_date_formated',$startDate->format('d/m/Y'));
       $referer = $this->getRequest()->headers->get('referer');   
         return new RedirectResponse($referer);
    }
}