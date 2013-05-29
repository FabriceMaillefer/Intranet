<?php

namespace FMR\OffreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\OffreBundle\Entity\StatutOffre;
use FMR\OffreBundle\Form\StatutOffreType;

/**
 * StatutOffre controller.
 *
 * @Route("/statutoffre")
 */
class StatutOffreController extends Controller
{
    /**
     * Lists all StatutOffre entities.
     *
     * @Route("/", name="statutoffre")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FMROffreBundle:StatutOffre')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new StatutOffre entity.
     *
     * @Route("/", name="statutoffre_create")
     * @Method("POST")
     * @Template("FMROffreBundle:StatutOffre:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new StatutOffre();
        $form = $this->createForm(new StatutOffreType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
			$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation compl&egrave;te');
		
            return $this->redirect($this->generateUrl('statutoffre_show', array('id' => $entity->getId())));
        }
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la cr&eacute;ation');
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new StatutOffre entity.
     *
     * @Route("/new", name="statutoffre_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new StatutOffre();
        $form   = $this->createForm(new StatutOffreType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a StatutOffre entity.
     *
     * @Route("/{id}", name="statutoffre_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMROffreBundle:StatutOffre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StatutOffre entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing StatutOffre entity.
     *
     * @Route("/{id}/edit", name="statutoffre_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMROffreBundle:StatutOffre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StatutOffre entity.');
        }

        $editForm = $this->createForm(new StatutOffreType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing StatutOffre entity.
     *
     * @Route("/{id}", name="statutoffre_update")
     * @Method("PUT")
     * @Template("FMROffreBundle:StatutOffre:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMROffreBundle:StatutOffre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StatutOffre entity.');
        }

        $editForm = $this->createForm(new StatutOffreType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

            return $this->redirect($this->generateUrl('statutoffre_edit', array('id' => $id)));
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a StatutOffre entity.
     *
     * @Route("/{id}/delete", name="statutoffre_delete")
     *@Method("GET")
     */
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('FMROffreBundle:StatutOffre')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find StatutOffre entity.');
		}
		
		$em->remove($entity);
		$em->flush();
            
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');

		return $this->redirect($this->generateUrl('statutoffre'));
	}
}
