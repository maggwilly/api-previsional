<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Etape;
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

    /**
     * Lists all etape entities.
     *
     */
    public function AccueilAction()
    {
        $em = $this->getDoctrine()->getManager();

        $session = $this->getRequest()->getSession();

    $nombrePointVente = $em->getRepository('AppBundle:PointVente')->nombrePointVente($session->get('region'),$session->get('startDate'),$session->get('endDate'));
    $nombrePointVenteVisite = $em->getRepository('AppBundle:PointVente')->nombrePointVenteVisite($session->get('region'),$session->get('startDate'),$session->get('endDate'));
    $nombreVisite = $em->getRepository('AppBundle:Visite')->nombreVisite($session->get('region'),$session->get('startDate'),$session->get('endDate'));
        $excApp = $em->getRepository('AppBundle:Visite')->excApp($session->get('region'),$session->get('startDate'),$session->get('endDate'));
      

        $situations = $em->getRepository('AppBundle:Produit')->stockParProduit($session->get('region'),$session->get('startDate'),$session->get('endDate'));

        $visibilites = $em->getRepository('AppBundle:Produit')->visibilitekParProduit($session->get('region'),$session->get('startDate'),$session->get('endDate'));

        $respectPrixs = $em->getRepository('AppBundle:Produit')->respectPrixParProduit($session->get('region'),$session->get('startDate'),$session->get('endDate'));

        $visitesParSemaine = $em->getRepository('AppBundle:PointVente')->visitesParSemaine($session->get('region'),$session->get('startDate'),$session->get('endDate'));

        return $this->render('AppBundle::layout.html.twig',
            array(
                'nombrePointVente'=>$nombrePointVente ,
                'nombrePointVenteVisite'=>$nombrePointVenteVisite,
                'nombreVisite'=>$nombreVisite,
                'tauxExc'=>$nombrePointVenteVisite>0?$excApp[0]['exc']*100/$nombrePointVenteVisite:'--',
                 'exc'=>$excApp[0]['exc'],
                'tauxApp'=>$nombrePointVenteVisite>0?$excApp[0]['sapp']*100/$nombrePointVenteVisite:'--',
                 'nApp'=>$nombrePointVenteVisite>0?$nombrePointVenteVisite-$excApp[0]['sapp']:'--',
                'tauxAff'=>$nombrePointVenteVisite>0?$excApp[0]['aff']*100/$nombrePointVenteVisite:'--',
                  'nAff'=>$nombrePointVenteVisite>0?$nombrePointVenteVisite-$excApp[0]['aff']:'--',
                'situations'=>$situations,
                'visibilites'=>$visibilites,
                'respectPrixs'=>$respectPrixs,
                'visitesParSemaine'=>$visitesParSemaine,
                ));
    }
    /**
     * Finds and displays a etape entity.
     *
     */
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

        $session->set('end_date_formated',$endDate->format('d/m/Y'));
        $session->set('start_date_formated',$startDate->format('d/m/Y'));

       $referer = $this->getRequest()->headers->get('referer');   
         return new RedirectResponse($referer);
    }
}
