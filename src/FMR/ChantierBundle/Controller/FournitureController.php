<?php

namespace FMR\ChantierBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FMR\ChantierBundle\Entity\Fourniture;
use FMR\ChantierBundle\Entity\Fourniture1D;
use FMR\ChantierBundle\Entity\Fourniture2D;
use FMR\ChantierBundle\Entity\Fourniture3D;
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
    	    
    	$fournitures = $chantier->getFournitures();
    	if ($chantier->getFacture()){
    		$this->get('session')->getFlashBag()->add('info', 'Ce chantier est déjà facturé. Les nouvelles fournitures ajoutées ne seront pas facturées.');    		
    	}
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
    	$type=$request->request->get('_type');

    	$classe = 'FMR\ChantierBundle\Entity\Fourniture'.$type;
        $entity  = new $classe();
        
        $form = $this->createForm($entity->getForm(), $entity);
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
        	'type' => $type,
        );
    }

    /**
     * Displays a form to create a new Fourniture entity.
     *
     * @Route("/chantier/{id}/new/{type}", name="fourniture_new")
     * 
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request, Chantier $chantier, $type="")
    {
    	
    	
        $classe = 'FMR\ChantierBundle\Entity\Fourniture'.$type;
        $entity  = new $classe();
        
        $entity->setChantier($chantier);
        
        $form   = $this->createForm($entity->getForm(), $entity);

        $return_options = array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'chantier'=> $chantier,
        	'type' => $type,
        );
        
		if ($request->isXmlHttpRequest()){
			return $this->render(
					'FMRChantierBundle:Fourniture:new_single.html.twig',
					$return_options
			);
    	}
        return $return_options;
    }


    /**
     * Displays a form to edit an existing Fourniture entity.
     *
     * @Route("/{id}/edit", name="fourniture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FMRChantierBundle:Fourniture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fourniture entity.');
        }

        $editForm = $this->createForm($entity->getForm(), $entity);

        
        $return_options = array(
        		'entity' => $entity,
        		'edit_form'   => $editForm->createView(),
        );
        
        if ($request->isXmlHttpRequest()){
        	return $this->render(
        			'FMRChantierBundle:Fourniture:edit_single.html.twig',
        			$return_options
        	);
        }
        return $return_options;
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

        $editForm = $this->createForm($entity->getForm(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Modification r&eacute;ussie');

            return $this->redirect($this->generateUrl('chantier_fourniture', array('id' => $entity->getChantier()->getId())));
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
