<?php

namespace Busko\EntityBundle\Controller;

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

        return $this->render('BuskoEntityBundle:Intermediates:index.html.twig', array(
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

            return $this->redirect($this->generateUrl('intermediates_show', array('id' => $entity->getId())));
        }

        return $this->render('BuskoEntityBundle:Intermediates:new.html.twig', array(
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

        return $this->render('BuskoEntityBundle:Intermediates:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Intermediates entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Intermediates')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intermediates entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoEntityBundle:Intermediates:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Intermediates entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Intermediates')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intermediates entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoEntityBundle:Intermediates:edit.html.twig', array(
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
            'action' => $this->generateUrl('intermediates_update', array('id' => $entity->getId())),
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

        $entity = $em->getRepository('BuskoEntityBundle:Intermediates')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intermediates entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('intermediates_edit', array('id' => $id)));
        }

        return $this->render('BuskoEntityBundle:Intermediates:edit.html.twig', array(
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
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BuskoEntityBundle:Intermediates')->find($id);

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
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('intermediates_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
