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
        
        return $this->render('overview/overview.html.twig');
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
