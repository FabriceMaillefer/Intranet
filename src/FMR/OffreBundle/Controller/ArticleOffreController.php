<?php

namespace FMR\OffreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\OffreBundle\Entity\ArticleOffre;
use FMR\OffreBundle\Form\ArticleOffreType;
use FMR\OffreBundle\Entity\Offre;

/**
 * ArticleOffre controller.
 *
 * @Route("/articleoffre")
 */
class ArticleOffreController extends Controller
{
   
    /**
     * Creates a new ArticleOffre entity.
     *
     * @Route("/offre/{id}/", name="articleoffre_create")
     * @Method("POST")
     * @Template("FMROffreBundle:ArticleOffre:new.html.twig")
     */
    public function createAction(Request $request,Offre $offre)
    {
        $entity  = new ArticleOffre();
        $form = $this->createForm(new ArticleOffreType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setOffre($offre);
            $em->persist($entity);
            $em->flush();
            
			$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation compl&egrave;te');
			
            return $this->redirect($this->generateUrl('offre_show', array('id' => $entity->getOffre()->getId())));
        }
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la cr&eacute;ation');
        
        return array(
            'entity' => $entity,
        	'offre' => $offre,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new ArticleOffre entity.
     *
     * @Route("/offre/{id}/new", name="articleoffre_new")
     * @Method("GET")
     * @Template("FMROffreBundle:ArticleOffre:new_single.html.twig")
     */
    public function newAction(Offre $offre)
    {
        $entity = new ArticleOffre();
        $entity->setOffre($offre);
        $form   = $this->createForm(new ArticleOffreType(), $entity);

        return array(
            'entity' => $entity,
        	'offre' => $offre,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to edit an existing ArticleOffre entity.
     *
     * @Route("/{id}/edit", name="articleoffre_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMROffreBundle:ArticleOffre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArticleOffre entity.');
        }

        $editForm = $this->createForm(new ArticleOffreType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing ArticleOffre entity.
     *
     * @Route("/{id}", name="articleoffre_update")
     * @Method("PUT")
     * @Template("FMROffreBundle:ArticleOffre:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMROffreBundle:ArticleOffre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArticleOffre entity.');
        }

        $editForm = $this->createForm(new ArticleOffreType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

            return $this->redirect($this->generateUrl('offre_show', array('id' => $entity->getOffre()->getId())));
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a ArticleOffre entity.
     *
     * @Route("/{id}/delete", name="articleoffre_delete")
     *@Method("GET")
     */
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('FMROffreBundle:ArticleOffre')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find ArticleOffre entity.');
		}
		
		$offre = $entity->getOffre();
		
		$em->remove($entity);
		$em->flush();
            
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');

		return $this->redirect($this->generateUrl('offre_show', array('id' => $offre->getId())));
	}
}
