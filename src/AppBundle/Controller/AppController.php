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
        
        return $this->render('layout.html.twig');
    }

    public function overviewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getRequest()->getSession();
        $date = new \DateTime();
        $week = $date->format("W");
        $year=$date->format("Y");
        $date->setISODate($year, $week);
        $weekStart = $date->format('Y-m-d');
        $date->modify('+6 days');
        $weekEnd=$date->format('Y-m-d'); 
        $region=$session->get('region');
        $startDate=$session->get('startDate',$weekStart);
        $endDate=$session->get('endDate',$weekEnd);     

        $phoningsGroup = $em->getRepository('AppBundle:Phoning')->findGroupByIssu($region, $startDate, $endDate);
        $rendezVous = $em->getRepository('AppBundle:RendezVous')->findList($region,$startDate,$endDate); 
        $activationsReuissites = $em->getRepository('AppBundle:Activation')->findList( $region,$startDate,$endDate,true);
        $activations = $em->getRepository('AppBundle:Activation')->findList( $region,$startDate,$endDate);
        $ventes = $em->getRepository('AppBundle:Vente')->findList($region,$startDate, $endDate);
        $ventesGroup = $em->getRepository('AppBundle:Vente')->findGroupByMarque($region,$startDate, $endDate);

        return $this->render('overview/overview.html.twig',
         array(
            'phoningsGroup' => $phoningsGroup,
            'ventesGroup' => $ventesGroup, 
            'activationsReuissites'=>count($activationsReuissites),
            'activations'=>count($activations),
            'ventes'=>count($ventes),
            'rendezVous'=>count($rendezVous),
        ));
    }

    public function setPeriodeAction(Request $request)
    {
        $session = $this->getRequest()->getSession();
        $region=$request->request->get('region');
        $periode= $request->request->get('periode');
        $startDate= $request->request->get('start_date');
        $endDate= $request->request->get('end_date');
        $format = 'd/m/Y';
        $startDate= \DateTime::createFromFormat($format, $startDate);
        $endDate= \DateTime::createFromFormat($format,  $endDate);
        $session->set('region',$region);
        $session->set('startDate',$startDate->format('Y-m-d'));
        $session->set('endDate',$endDate->format('Y-m-d'));
        $session->set('end_date_formated',$endDate->format('d/m/Y'));
        $session->set('start_date_formated',$startDate->format('d/m/Y'));
        $referer = $this->getRequest()->headers->get('referer');   
         return new RedirectResponse($referer);
    }
}
