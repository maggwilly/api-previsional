<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Article;
use AppBundle\Entity\Content;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Content controller.
 *
 */
class ContentController extends Controller
{
 /**
 * @Security("is_granted('ROLE_SAISIE')")
*/
    public function indexAction(Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $contents = $em->getRepository('AppBundle:Content')->findAll();
        return $this->render('content/index.html.twig', array(
            'contents' => $article->getContents(),'article' => $article
        ));
    }

 /**
 * @Security("is_granted('ROLE_SAISIE')")
*/
    public function newAction(Request $request,Article $article)
    {
        $content = new Content();
        $form = $this->createForm('AppBundle\Form\ContentType', $content);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
             $content->setArticle( $article);
            $em->persist($content);
            $em->flush($content);
            $this->addFlash('success', 'Enrégistrement effectué');
            return $this->redirectToRoute('content_new', array('id' => $article->getId() ));
        }elseif($form->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');
        return $this->render('content/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

 /**
 * @Security("is_granted('ROLE_SAISIE')")
*/
 public function toggleAction(Content $content){
            $em = $this->getDoctrine()->getManager();
            $isValid=$content->getValidated()?true:false;
             $content->setValidated(! $isValid);
              $em->flush($content);
    return $this->redirectToRoute('content_index', array('id' => $content->getArticle()->getId() ));
 }
    /**
     * Finds and displays a partie entity.
     *
     */
    public function getBlockedPersonsAction(Content $content)
    {
         $url="https://trainings-fa73e.firebaseio.com/status/content/".$content->getArticle()->getId().'/'.$content->getId()."/.json";
         $res =!is_null($this->get('fmc_manager')->sendOrGetData($url,null,'GET')) ?$this->get('fmc_manager')->sendOrGetData($url,null,'GET'):array(); 
        return  new Response(''.count($res));
    }


 /**
 * @Security("is_granted('ROLE_SAISIE')")
*/
    public function showAction(Content $content)
    {
        $deleteForm = $this->createDeleteForm($content);
        return $this->render('content/show.html.twig', array(
            'content' => $content,
            'delete_form' => $deleteForm->createView(),
        ));
    }

 /**
 * @Security("is_granted('ROLE_SAISIE')")
*/
    public function editAction(Request $request, Content $content)
    {
        $deleteForm = $this->createDeleteForm($content);
        $editForm = $this->createForm('AppBundle\Form\ContentType', $content);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
               $this->addFlash('success', 'Modifications  enrégistrées avec succès.');
            return $this->redirectToRoute('content_edit', array('id' => $content->getId()));
        }elseif($editForm->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('content/edit.html.twig', array(
            'content' => $content,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a content entity.
     *
     */
    public function deleteAction(Request $request, Content $content)
    {
        $form = $this->createDeleteForm($content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($content);
            $em->flush($content);
            $this->addFlash('success', 'Supprimé.');
        }

        return $this->redirectToRoute('content_index');
    }

    /**
     * Creates a form to delete a content entity.
     *
     * @param Content $content The content entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Content $content)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('content_delete', array('id' => $content->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
