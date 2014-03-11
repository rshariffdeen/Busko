<?php

namespace Busko\EmployeeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Busko\EntityBundle\Entity\Drivers;
use Busko\EntityBundle\Form\DriversType;

/**
 * Drivers controller.
 *
 */
class DriversController extends Controller
{

    /**
     * Lists all Drivers entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BuskoEntityBundle:Drivers')->findAll();

        return $this->render('BuskoEmployeeBundle:Drivers:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Drivers entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Drivers();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('drivers_show', array('id' => $entity->getId())));
        }

        return $this->render('BuskoEmployeeBundle:Drivers:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Drivers entity.
    *
    * @param Drivers $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Drivers $entity)
    {
        $form = $this->createForm(new DriversType(), $entity, array(
            'action' => $this->generateUrl('drivers_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Drivers entity.
     *
     */
    public function newAction()
    {
        $entity = new Drivers();
        $form   = $this->createCreateForm($entity);

        return $this->render('BuskoEmployeeBundle:Drivers:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Drivers entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Employees')->findOneBy(array('username' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Drivers entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoEmployeeBundle:Drivers:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Drivers entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Drivers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Drivers entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoEmployeeBundle:Drivers:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Drivers entity.
    *
    * @param Drivers $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Drivers $entity)
    {
        $form = $this->createForm(new DriversType(), $entity, array(
            'action' => $this->generateUrl('drivers_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Drivers entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Drivers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Drivers entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('drivers_edit', array('id' => $id)));
        }

        return $this->render('BuskoEmployeeBundle:Drivers:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Drivers entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BuskoEntityBundle:Drivers')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Drivers entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('drivers'));
    }

    /**
     * Creates a form to delete a Drivers entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('drivers_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
