<?php

namespace Busko\BranchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Busko\EntityBundle\Entity\BusStops;
use Busko\EntityBundle\Form\BusStopsType;

/**
 * BusStops controller.
 *
 */
class BusStopsController extends Controller
{

    /**
     * Lists all BusStops entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BuskoEntityBundle:BusStops')->findAll();

        return $this->render('BuskoBranchBundle:BusStops:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new BusStops entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new BusStops();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('busstops_show', array('id' => $entity->getStopId())));
        }

        return $this->render('BuskoBranchBundle:BusStops:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a BusStops entity.
    *
    * @param BusStops $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(BusStops $entity)
    {
        $form = $this->createForm(new BusStopsType(), $entity, array(
            'action' => $this->generateUrl('busstops_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new BusStops entity.
     *
     */
    public function newAction()
    {
        $entity = new BusStops();
        $form   = $this->createCreateForm($entity);

        return $this->render('BuskoBranchBundle:BusStops:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BusStops entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:BusStops')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BusStops entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoBranchBundle:BusStops:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing BusStops entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:BusStops')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BusStops entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoBranchBundle:BusStops:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a BusStops entity.
    *
    * @param BusStops $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(BusStops $entity)
    {
        $form = $this->createForm(new BusStopsType(), $entity, array(
            'action' => $this->generateUrl('busstops_update', array('id' => $entity->getStopId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing BusStops entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:BusStops')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BusStops entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('busstops_edit', array('id' => $id)));
        }

        return $this->render('BuskoBranchBundle:BusStops:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a BusStops entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BuskoEntityBundle:BusStops')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BusStops entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('busstops'));
    }

    /**
     * Creates a form to delete a BusStops entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('busstops_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
