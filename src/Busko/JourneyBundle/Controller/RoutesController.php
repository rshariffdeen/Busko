<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Busko\EntityBundle\Entity\Routes;
use Busko\EntityBundle\Form\RoutesType;
use Busko\EntityBundle\Entity\Intermediates;

/**
 * Routes controller.
 *
 */
class RoutesController extends Controller
{

    /**
     * Lists all Routes entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createSearchForm();
        $entities = $em->getRepository('BuskoEntityBundle:Routes')->findAll();

        return $this->render('BuskoJourneyBundle:Routes:index.html.twig', array(
            'entities' => $entities,'form'=>$form->createView(),
        ));
    }
    /**
     * Creates a new Routes entity.
     *
     */
    public function createAction(Request $request)
    {
        
        $entity = new Routes();
        $inter = new Intermediates();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $inter->setDuration('');
        

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if($entity->getEndStop()===$entity->getStartStop()){
                return $this->render('BuskoJourneyBundle:Routes:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(), 'type' => 'E', 'message' => 'start and end stops canot be same',
        )); 
            }
            $inter->setRouteId($entity->getRouteId());
            $inter->setstationNumber((int)'0');
            $inter->setStopId($entity->getStartStop());
            $em->persist($inter);
            $em->persist($entity);
            try{
            $em->flush();
            } 
            catch(\Exception $e){
                return $this->render('BuskoJourneyBundle:Routes:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(), 'type' => 'E', 'message' => 'exception! something was not right',
        ));
            }
            return $this->redirect($this->generateUrl('intermediates_createInter', array('rId' => $entity->getRouteId(),'num'=>(int)'1','type' => 'S', 'message' => 'Route Sucsessfuly created',)));
        }

        return $this->render('BuskoJourneyBundle:Routes:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Routes entity.
    *
    * @param Routes $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Routes $entity)
    {
        $form = $this->createForm(new RoutesType(), $entity, array(
            'action' => $this->generateUrl('routes_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Routes entity.
     *
     */
    public function newAction()
    {
        $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

        if ((in_array("ADMIN", $user->getRoles()))) {
           
        }else {if ((in_array("OPERATOR", $user->getRoles()))) {
          
        }else
         return $this->forward('FOSUserBundle:Security:login');
        }
        $entity = new Routes();
        $form   = $this->createCreateForm($entity);

        return $this->render('BuskoJourneyBundle:Routes:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Routes entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Routes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Routes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoJourneyBundle:Routes:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Routes entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Routes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Routes entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoJourneyBundle:Routes:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Routes entity.
    *
    * @param Routes $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Routes $entity)
    {
        $form = $this->createForm(new RoutesType(), $entity, array(
            'action' => $this->generateUrl('routes_update', array('id' => $entity->getRouteId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Routes entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Routes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Routes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('routes_edit', array('id' => $id)));
        }

        return $this->render('BuskoJourneyBundle:Routes:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Routes entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BuskoEntityBundle:Routes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Routes entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('routes'));
    }

    /**
     * Creates a form to delete a Routes entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('routes_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    public function searchAction(Request $request) {
         $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

        
        $em = $this->getDoctrine()->getManager();
        $form = $this->createSearchForm();
        $form->handleRequest($request);
        $entity = null;
        
        if ($form->isValid()) {
            $id = $form["routeId"]->getData();
           

            $entity = $em->getRepository('BuskoEntityBundle:Routes')->find($id);
           
           
            if (in_array("ADMIN", $user->getRoles())) {
            
        }else {
            if (in_array("OPERATOR", $user->getRoles())) {
            }else{
        
                return $this->render('BuskoJourneyBundle:Routes:search.html.twig', array(
                        'entities' => $entity,
                        'search' => $form->createView(),
                        'request'=>$request
            ));
        } }

            return $this->render('BuskoJourneyBundle:Routes:searchAdmin.html.twig', array(
                        'entities' => $entity,
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
     public function createSearchForm() {
        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('routes_search'))
                ->setMethod('POST')
                ->add('routeId', 'entity', array(
            'label' =>'Route Id',
            'label_attr' => array('class' => 'control-label'),
            'attr' => array(
            'class' =>'controls',
                'data-rel'=>'chosen'
                )
            ,
            'class' => 'BuskoEntityBundle:Routes',
            'property' => 'routeId',
            ))
                ->add('search', 'submit', array('attr'=>array('class'=>'btn btn-primary')))
                ->getForm();

        return $form;
    }
}
