<?php

namespace FMR\ChantierBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\ChantierBundle\Entity\Fourniture;
use FMR\ChantierBundle\Form\FournitureType;
use FMR\ChantierBundle\Entity\Chantier;

/**
 * Fourniture controller.
 *
 * @Route("/fourniture")
 */
class FournitureController extends Controller
{
    /**
     * Lists all Fourniture entities for a Chantier Entity.
     *
     * @Route("/chantier/{id}/", name="chantier_fourniture")
     * @Method("GET")
     * @Template("FMRChantierBundle:Fourniture:list.html.twig")
     */
    public function listFournitureChantierAction(Chantier $chantier)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$fournitures = $em->getRepository('FMRChantierBundle:Fourniture')->findByChantier($chantier);
    
    	return array(
    			'fournitures' => $fournitures,
    			'chantier' => $chantier,
    	);
    }
    
    /**
     * Creates a new Fourniture entity.
     *
     * @Route("/chantier/{id}/", name="fourniture_create")
     * @Method("POST")
     * @Template("FMRChantierBundle:Fourniture:new.html.twig")
     */
    public function createAction(Request $request, Chantier $chantier)
    {
        $entity  = new Fourniture();
        $form = $this->createForm(new FournitureType(), $entity);
        $form->bind($request);

        $entity->setChantier($chantier);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($entity);
            $em->flush();
            
			$this->get('session')->getFlashBag()->add('success', 'Cr&eacute;ation compl&egrave;te');
		
            return $this->redirect($this->generateUrl('chantier_fourniture', array('id' => $entity->getChantier()->getId())));
        }
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la cr&eacute;ation');
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'chantier'=> $chantier,
        );
    }

    /**
     * Displays a form to create a new Fourniture entity.
     *
     * @Route("/chantier/{id}/new", name="fourniture_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request, Chantier $chantier)
    {
    	
    	
        $entity = new Fourniture();
        $entity->setChantier($chantier);
        
        $form   = $this->createForm(new FournitureType(), $entity);
        
		if ($request->isXmlHttpRequest()){
			return $this->render(
					'FMRChantierBundle:Fourniture:new_single.html.twig',
					array(
							'entity' => $entity,
				            'form'   => $form->createView(),
							'chantier'=> $chantier,
					)
			);
    	}
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'chantier'=> $chantier,
        );
    }

    /**
     * Finds and displays a Fourniture entity.
     *
     * @Route("/{id}", name="fourniture_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMRChantierBundle:Fourniture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fourniture entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Fourniture entity.
     *
     * @Route("/{id}/edit", name="fourniture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMRChantierBundle:Fourniture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fourniture entity.');
        }

        $editForm = $this->createForm(new FournitureType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Fourniture entity.
     *
     * @Route("/{id}", name="fourniture_update")
     * @Method("PUT")
     * @Template("FMRChantierBundle:Fourniture:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMRChantierBundle:Fourniture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fourniture entity.');
        }

        $editForm = $this->createForm(new FournitureType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

            return $this->redirect($this->generateUrl('fourniture_edit', array('id' => $id)));
        }
        
		$this->get('session')->getFlashBag()->add('error', 'Erreur lors de la modification');
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Fourniture entity.
     *
     * @Route("/{id}/delete", name="fourniture_delete")
     *@Method("GET")
     */
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('FMRChantierBundle:Fourniture')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Fourniture entity.');
		}
		
		$em->remove($entity);
		$em->flush();
            
		$this->get('session')->getFlashBag()->add('success', 'Supression accomplie !');

		return $this->redirect($this->generateUrl('chantier_fourniture', array('id' => $entity->getChantier()->getId())));	}
}
