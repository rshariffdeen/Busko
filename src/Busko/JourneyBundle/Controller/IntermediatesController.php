<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Busko\EntityBundle\Entity\Intermediates;
use Busko\EntityBundle\Form\IntermediatesType;

/**
 * Intermediates controller.
 *
 */
class IntermediatesController extends Controller
{

    /**
     * Lists all Intermediates entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BuskoEntityBundle:Intermediates')->findAll();

        return $this->render('BuskoJourneyBundle:Intermediates:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Intermediates entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Intermediates();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('intermediates_show', array('id' => $entity-> getStopId(),'rId' => $entity->getRouteId())));
        }

        return $this->render('BuskoJourneyBundle:Intermediates:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Intermediates entity.
    *
    * @param Intermediates $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Intermediates $entity)
    {
        $form = $this->createForm(new IntermediatesType(), $entity, array(
            'action' => $this->generateUrl('intermediates_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Intermediates entity.
     *
     */
    public function newAction()
    {
        $entity = new Intermediates();
        $form   = $this->createCreateForm($entity);

        return $this->render('BuskoJourneyBundle:Intermediates:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Intermediates entity.
     *
     */
    public function showAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rId=$request->get('rId');
        $entity = $em->getRepository('BuskoEntityBundle:Intermediates')->findOneBy(array("stopId"=>$id,"routeId"=>$rId));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intermediates entity.');
        }

        $deleteForm = $this->createDeleteForm($id,$rId);

        return $this->render('BuskoJourneyBundle:Intermediates:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Intermediates entity.
     *
     */
    public function editAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $rId=$request->get('rId');
        $entity = $em->getRepository('BuskoEntityBundle:Intermediates')->findOneBy(array("stopId"=>$id,"routeId"=>$rId));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intermediates entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id,$rId);

        return $this->render('BuskoJourneyBundle:Intermediates:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Intermediates entity.
    *
    * @param Intermediates $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Intermediates $entity)
    {
        $form = $this->createForm(new IntermediatesType(), $entity, array(
            'action' => $this->generateUrl('intermediates_update', array('id' => $entity-> getStopId(),'rId' => $entity->getRouteId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Intermediates entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $rId=$request->get('rId');
        $entity = $em->getRepository('BuskoEntityBundle:Intermediates')->findOneBy(array("stopId"=>$id,"routeId"=>$rId));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intermediates entity.');
        }

        $deleteForm = $this->createDeleteForm($id,$rId);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('intermediates_edit', array('id' => $id,'rId'=> $rId)));
        }

        return $this->render('BuskoJourneyBundle:Intermediates:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Intermediates entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {   
        $rId=$request->get('rId');
        

        $form = $this->createDeleteForm($id,$rId);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BuskoEntityBundle:Intermediates')->findOneBy(array("stopId"=>$id,"routeId"=>$rId));

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Intermediates entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('intermediates'));
    }

    /**
     * Creates a form to delete a Intermediates entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id,$rId)
    {
         //$rId=$request->get('rId');
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('intermediates_delete', array('id' => $id,'rId'=> $rId)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}