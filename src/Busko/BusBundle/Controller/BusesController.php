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
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BuskoEntityBundle:Buses')->findAll();
        return $this->render('BuskoBusBundle:Buses:index.html.twig', array(
                    'entities' => $entities,
                    'request' => $request,
                    'type' => $request->get('type'), 'message' => $request->get('message')
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
            try{
            $em->flush();
            }
            catch(\Exception $e){
                return $this->render('BuskoStyleBundle:Error:error.html.twig', array(
                    'message' => ' new bus could not be added'
                    
                    
        ));
            }

            return $this->redirect($this->generateUrl('site_bus',array('type' => 'S',
                    'message' => "succesfully added new bus")));
        }

        return $this->render('BuskoBusBundle:Buses:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView()
                    
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
            'attr' => array(
                'class' => 'btn btn-success'
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
             return $this->render('BuskoStyleBundle:Error:error.html.twig', array(
                    'message' => ' bus could not be found'                   
                    
        ));}

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
                'class' => 'form-horizontal center'
            )
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-inverse')));

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
             return $this->render('BuskoStyleBundle:Error:error.html.twig', array(
                    'message' => ' bus could not be found'
                    
                    
        ));}


        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            try{
                $em->persist($entity);
            $em->flush();
            }
            
            catch(\Exception $e){
                return $this->redirect($this->generateUrl('site_bus',array('type' => 'E',
                    'message' => "details were not updated. make sure not to duplicate entries")));
            }

            return $this->redirect($this->generateUrl('site_bus',array('type' => 'S',
                    'message' => "succesfully updated details of the bus")));
        }

        return $this->render('BuskoBusBundle:Buses:form.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
            'type' => 'E',
                    'message' => "ops! something was wrong!"
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
            return $this->render('BuskoStyleBundle:Error:error.html.twig', array(
                    'message' => ' bus was not be found'
                    
                    
        ));}
        
        try{
        $em->remove($entity);
        $em->flush();
        }
        catch(\Exception $e){
                return $this->redirect($this->generateUrl('site_bus',array('type' => 'E',
                    'message' => "could not delete the bus. make sure it has no journeys assigned")));
            }

         return $this->redirect($this->generateUrl('site_bus',array('type' => 'S',
                    'message' => "successfully deleted the bus")));
            
    }

    /**
     * Creates a form to delete a Buses entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
}
