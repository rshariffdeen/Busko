<?php

namespace Busko\EmployeeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Entity\Assistants;
use Busko\EntityBundle\Form\AssistantsType;
use Busko\EntityBundle\Entity\Employees;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Assistants controller.
 *
 */
class AssistantsController extends Controller {

    /**
     * Lists all Assistants entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BuskoEntityBundle:Assistants')->findAll();

        return $this->render('BuskoEmployeeBundle:Assistants:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Assistants entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Assistants();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('assistants_show', array('id' => $entity->getId())));
        }

        return $this->render('BuskoEmployeeBundle:Assistants:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Assistants entity.
     *
     * @param Assistants $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Assistants $entity) {
        $form = $this->createForm(new AssistantsType(), $entity, array(
            'action' => $this->generateUrl('assistants_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Assistants entity.
     *
     */
    public function newAction() {
        $entity = new Assistants();
        $form = $this->createCreateForm($entity);

        return $this->render('BuskoEmployeeBundle:Assistants:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Assistants entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserByUsername($id);
        $id = $user->getId();
        $entity = $em->getRepository('BuskoEntityBundle:Assistants')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Assistants entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoEmployeeBundle:Assistants:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Assistants entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserByUsername($id);
        $id = $user->getId();
        $entity = $em->getRepository('BuskoEntityBundle:Assistants')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Assistants entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoEmployeeBundle:Assistants:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Assistants entity.
     *
     * @param Assistants $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Assistants $entity) {
        $form = $this->createForm(new AssistantsType(), $entity, array(
            'action' => $this->generateUrl('assistants_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Assistants entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
       
        $entity = $em->getRepository('BuskoEntityBundle:Assistants')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Assistants entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('assistants_edit', array('id' => $id)));
        }

        return $this->render('BuskoEmployeeBundle:Assistants:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Assistants entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userManager = $this->container->get('fos_user.user_manager');
            $user = $userManager->findUserByUsername($id);
            $id = $user->getId();
            $entity = $em->getRepository('BuskoEntityBundle:Assistants')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Assistants entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('assistants'));
    }

    /**
     * Creates a form to delete a Assistants entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('assistants_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
