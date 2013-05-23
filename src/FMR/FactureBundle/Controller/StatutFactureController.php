<?php

namespace FMR\FactureBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\FactureBundle\Entity\StatutFacture;
use FMR\FactureBundle\Form\StatutFactureType;

/**
 * StatutFacture controller.
 *
 * @Route("/statutfacture")
 */
class StatutFactureController extends Controller
{
    /**
     * Lists all StatutFacture entities.
     *
     * @Route("/", name="statutfacture")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FMRFactureBundle:StatutFacture')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new StatutFacture entity.
     *
     * @Route("/", name="statutfacture_create")
     * @Method("POST")
     * @Template("FMRFactureBundle:StatutFacture:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new StatutFacture();
        $form = $this->createForm(new StatutFactureType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
			$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation compl&egrave;te');
		
            return $this->redirect($this->generateUrl('statutfacture_show', array('id' => $entity->getId())));
        }
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la cr&eacute;ation');
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new StatutFacture entity.
     *
     * @Route("/new", name="statutfacture_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new StatutFacture();
        $form   = $this->createForm(new StatutFactureType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a StatutFacture entity.
     *
     * @Route("/{id}", name="statutfacture_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMRFactureBundle:StatutFacture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StatutFacture entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing StatutFacture entity.
     *
     * @Route("/{id}/edit", name="statutfacture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMRFactureBundle:StatutFacture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StatutFacture entity.');
        }

        $editForm = $this->createForm(new StatutFactureType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing StatutFacture entity.
     *
     * @Route("/{id}", name="statutfacture_update")
     * @Method("PUT")
     * @Template("FMRFactureBundle:StatutFacture:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMRFactureBundle:StatutFacture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StatutFacture entity.');
        }

        $editForm = $this->createForm(new StatutFactureType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

            return $this->redirect($this->generateUrl('statutfacture_edit', array('id' => $id)));
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a StatutFacture entity.
     *
     * @Route("/{id}/delete", name="statutfacture_delete")
     *@Method("GET")
     */
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('FMRFactureBundle:StatutFacture')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find StatutFacture entity.');
		}
		
		$em->remove($entity);
		$em->flush();
            
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');

		return $this->redirect($this->generateUrl('statutfacture'));
	}
}
