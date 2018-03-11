<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Article;
use AppBundle\Entity\Content;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Content controller.
 *
 */
class ContentController extends Controller
{
    /**
     * Lists all content entities.
     *
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
     * Creates a new content entity.
     *
     */
    public function newAction(Article $article,Request $request)
    {
        $content = new Content();
        $form = $this->createForm('AppBundle\Form\ContentType', $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
             $content->setArticle( $article);
            $em->persist($content);
            $em->flush($content);

            return $this->redirectToRoute('content_show', array('id' => $content->getId()));
        }

        return $this->render('content/new.html.twig', array(
            'content' => $content,'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Lists all Produit entities.
     *@Rest\View()
     */
    public function lireAction(Request $request,Session $session, Info $info)
    {
         $status=$request->query->get('status');
          if ($session!=null && $info!=null) {
                switch ($status) {
                    case 'true':
                        $session->addInfo($info);
                         $this->getDoctrine()->getManager()->flush();
                         return  true;
                    case 'false':
                          $session->removeInfo($info);
                           $this->getDoctrine()->getManager()->flush();
                        return  false;                    
                    default:
                    return !empty($this->getDoctrine()->getManager()->getRepository('AppBundle:Session')->findByUser($session,$info));  
                }
          }
         return  false;
    }

    /**
     * Finds and displays a content entity.
     *
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
     * Displays a form to edit an existing content entity.
     *
     */
    public function editAction(Request $request, Content $content)
    {
        $deleteForm = $this->createDeleteForm($content);
        $editForm = $this->createForm('AppBundle\Form\ContentType', $content);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('content_edit', array('id' => $content->getId()));
        }

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
