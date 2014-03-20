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
class BusStopsController extends Controller {

    /**
     * Lists all BusStops entities.
     *
     */
    
    public function indexAction() {

        $form = $this->createSearchForm();
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BuskoEntityBundle:BusStops')->findAll();

        return $this->render('BuskoBranchBundle:BusStops:index.html.twig', array(
                    'entities' => $entities, 'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new BusStops entity.
     *
     */
    
    public function createAction(Request $request) {
        $entity = new BusStops();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('site_route',array('smessage'=>'Bus Stop Added') ));
        }

        return $this->render('BuskoBranchBundle:BusStops:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    public function searchAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createSearchForm();
        $form->handleRequest($request);
        $entity = null;
        
        if ($form->isValid()) {
            $stop = $form["city"]->getData();
            $city=$stop->getCity();
            $repository = $em->getRepository('BuskoEntityBundle:BusStops');
            $query = $repository->createQueryBuilder('a')
                    ->where('a.city = :title')
                    ->setParameter('title', $city)
                    ->getQuery();
            $entities = $query->getResult();
           


            return $this->render('BuskoBranchBundle:BusStops:search.html.twig', array(
                        'entities' => $entities,
                        'search' => $form->createView(),
                        'request'=>$request
            ));
        }

        return $this->render('BuskoBranchBundle:BusStops:search.html.twig', array(
                    'entities' => $entity,
                    'form' => $form->createView(),
                    'request'=>$request
        ));
    }

    /**
     * Creates a form to create a BusStops entity.
     *
     * @param BusStops $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    
    private function createCreateForm(BusStops $entity) {
        $form = $this->createForm(new BusStopsType(), $entity, array(
            'action' => $this->generateUrl('busstops_create'),
            'method' => 'POST',
            'attr'  => array  ('class' =>'form-horizontal center')
        ));

        $form->add('submit', 'submit', array('label' => 'Create','attr'=>array('class'=>'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new BusStops entity.
     *
     */
    
    public function newAction() {
        $entity = new BusStops();
        $form = $this->createCreateForm($entity);

        return $this->render('BuskoBranchBundle:BusStops:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BusStops entity.
     *
     */
    
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:BusStops')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BusStops entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoBranchBundle:BusStops:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing BusStops entity.
     *
     */
    
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:BusStops')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BusStops entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoBranchBundle:BusStops:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
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
    
    private function createEditForm(BusStops $entity) {
        $form = $this->createForm(new BusStopsType(), $entity, array(
            'action' => $this->generateUrl('busstops_update', array('id' => $entity->getStopId())),
            'method' => 'PUT',
            'attr'  => array  ('class' =>'form-horizontal center')
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr'=> array('class'=>'btn btn-success')));

        return $form;
    }

    public function createSearchForm() {
        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('busstops_search'))
                ->setMethod('GET')
                ->add('city', 'entity', array(
            'label' =>'City',
            'label_attr' => array('class' => 'control-label'),
            'attr' => array(
            'class' =>'controls',
                'data-rel'=>'chosen'
                )
            ,
            'class' => 'BuskoEntityBundle:BusStops',
            'property' => 'city',
            ))
                ->add('search', 'submit', array('attr'=>array('class'=>'btn btn-primary')))
                ->getForm();

        return $form;
    }

    /**
     * Edits an existing BusStops entity.
     *
     */
    
    public function updateAction(Request $request, $id) {
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
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BusStops entity.
     *
     */
    
    public function deleteAction(Request $request) {
        $id = $request->get('id');
        $return =  $request->headers->get('referer');
        if (!$id){
        
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BuskoEntityBundle:BusStops')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BusStops entity.');
            }

            $em->remove($entity);
            $em->flush();
        
        }
        
        return $this->redirect($return,302 ,array('message' => "Oops! something went wrong",'type'=>'E'));
    
    }

    /**
     * Creates a form to delete a BusStops entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('busstops_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
