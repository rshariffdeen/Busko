<?php

namespace Busko\BusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Entity\Buses;
use Busko\EntityBundle\Form\BusesType;

/**
 * Buses controller.
 *
 */
class BusesController extends Controller {

    /**
     * Lists all Buses entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BuskoEntityBundle:Buses')->findAll();

        return $this->render('BuskoBusBundle:Buses:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Buses entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Buses();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity = $form->getData();


            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('buses_show', array('id' => $entity->getLicNum())));
        }

        return $this->render('BuskoBusBundle:Buses:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Buses entity.
     *
     * @param Buses $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Buses $entity) {
        $form = $this->createForm(new BusesType(), $entity, array(
            'action' => $this->generateUrl('buses_create'),            
            'method' => 'POST',
            'attr' => array(
                'class' => 'form-horizontal center',
            )
        ));

        $form->add('submit', 'submit', array('label' => 'Create',
            'attr'=> array(
                
                'class'=>'btn btn-success'
            )
            
            ));

        return $form;
    }

    /**
     * Displays a form to create a new Buses entity.
     *
     */
    public function newAction() {
        $entity = new Buses();
        $form = $this->createCreateForm($entity);

        return $this->render('BuskoBusBundle:Buses:form.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Buses entity.
     *
     */
   

    /**
     * Displays a form to edit an existing Buses entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Buses')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Buses entity.');
        }

        $editForm = $this->createEditForm($entity);
       
        return $this->render('BuskoBusBundle:Buses:form.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView(),
               
        ));
    }

    /**
     * Creates a form to edit a Buses entity.
     *
     * @param Buses $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Buses $entity) {
        $form = $this->createForm(new BusesType(), $entity, array(
            'action' => $this->generateUrl('buses_update', array('id' => $entity->getLicNum())),
            'method' => 'PUT',
            'attr' => array(
                'class'=>'form-horizontal center'
            )
            
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr'=> array( 'class'=>'btn btn-inverse')));

        return $form;
    }

    /**
     * Edits an existing Buses entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Buses')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Buses entity.');
        }

      
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('site_bus'));
        }

        return $this->render('BuskoBusBundle:Buses:form.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                   
        ));
    }

    /**
     * Deletes a Buses entity.
     *
     */
    public function deleteAction(Request $request) {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BuskoEntityBundle:Buses')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Buses entity.');
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('buses'));
    }

    /**
     * Creates a form to delete a Buses entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
   

}
