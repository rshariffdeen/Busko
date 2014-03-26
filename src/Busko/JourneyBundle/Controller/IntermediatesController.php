<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Busko\EntityBundle\Entity\Intermediates;
use Busko\EntityBundle\Form\IntermediatesType;
use Busko\EntityBundle\Form\RoutesAddType;
use Busko\EntityBundle\Entity\RoutesAdd;

/**
 * Intermediates controller.
 *
 */
class IntermediatesController extends Controller {

    /**
     * Lists all Intermediates entities.
     *
     */
    public function indexAction() {
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
    public function createAction(Request $request) {
        $entity = new Intermediates();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            try{
            $em->flush();
            }catch (\Exception $e){
                 return $this->render('BuskoJourneyBundle:Intermediates:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
            }
            

            return $this->redirect($this->generateUrl('site_route',array( 'type' => 'S', 'message' => 'Sucsessfuly create and finished saving Route')));
        }

        return $this->render('BuskoJourneyBundle:Intermediates:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    public function createRouteAction(Request $request, $rId) {
        $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

        if ((in_array("ADMIN", $user->getRoles()))) {
           
        }else {if ((in_array("OPERATOR", $user->getRoles()))) {
          
        }else
         return $this->forward('FOSUserBundle:Security:login');
        }
        $num = $request->get('num');
        $entity = new Intermediates();
        $entity->setstationNumber($num);
        $entity->setRouteId($rId);
        $entity2 = new Intermediates();
        $entity2->setstationNumber($num + (int) '1');
        $entity2->setRouteId($rId);
        $Stop = new RoutesAdd();
        $Stop->getStop()->add($entity);
        $Stop->getStop()->add($entity2);


        $form = $this->createForm(new RoutesAddType, $Stop, array(
            'action' => $this->generateUrl('intermediates_save', array('rId' => $rId, 'num' => $num)),
            'method' => 'POST',
        ));

        return $this->render('BuskoJourneyBundle:Intermediates:newInter.html.twig', array('rId' => $rId,'num'=>$num,
                    'form' => $form->createView(),'type'=>$request->get('type'),'message'=>$request->get('message'),
        ));
    }

    public function createRouteSaveAction(Request $request, $rId) {
        
        $num = $request->get('num');
        $em = $this->getDoctrine()->getManager();
        $Stop = new RoutesAdd();
        $entity = new Intermediates();
        $entity->setstationNumber($num);
        $entity->setRouteId($rId);
        $entity2 = new Intermediates();
        $entity2->setstationNumber($num + (int) '1');
        $entity2->setRouteId($rId);
        $Stop->getStop()->add($entity);
        $Stop->getStop()->add($entity2);
        $form = $this->createForm(new RoutesAddType, $Stop, array(
            'action' => $this->generateUrl('intermediates_save', array('rId' => $rId, 'num' => $num)),
            'method' => 'POST',
        ));

        $originalStops = new ArrayCollection();

        $form->bind($request);


        if ($form->isValid()) {

            $Stop = $form->getData();

            foreach ($Stop->getStop() as $tag) {
                $originalStops->add($tag);
            }
            
            foreach ($originalStops as $tag) {
                $Stop->getStop()->removeElement($tag);
                $tag->setRouteId($rId);
                $em->persist($tag);
                try {
                    $em->flush();
                } catch (\Exception $e) {
                    return $this->render('BuskoJourneyBundle:Intermediates:newInter.html.twig', array(
                                'form' => $form->createView(),'rId' => $rId,'num' => $num, 'type' => 'E', 'message' => 'exception! something was not right',
             
                    ));
                }
            }


            return $this->redirect($this->generateUrl('intermediates_createInter', array('rId' => $rId, 'num' => ($num + (int) '2'), 'type' => 'S', 'message' => 'sucsessfully save ',
  )));
        }

        return $this->render('BuskoJourneyBundle:Intermediates:newInter.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Intermediates entity.
     *
     * @param Intermediates $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Intermediates $entity) {
        $form = $this->createFormBuilder($entity)
            ->setAction( $this->generateUrl('intermediates_create'))
            ->setMethod('POST')
            ->add('stationNumber', 'text')
            ->add('stopId')
            ->add('routeId')
            ->add('duration')
            ->add('submit', 'submit', array('label' => 'Finished'))
            ->getForm();
//        $form = $this->createForm(new IntermediatesType(), $entity, array(
//            'action' => $this->generateUrl('intermediates_create'),
//            'method' => 'POST',
//        ));
//
//
//        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Intermediates entity.
     *
     */
    public function newAction(Request $request) {
        $user = $this->getUser();
        $rId=$request->get('rId');
        $num=$request->get('num');
        
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

       if ((in_array("ADMIN", $user->getRoles()))) {
           
        }else {if ((in_array("OPERATOR", $user->getRoles()))) {
          
        }else
         return $this->forward('FOSUserBundle:Security:login');
        }
        $em = $this->getDoctrine()->getManager();
        $route = $em->getRepository('BuskoEntityBundle:Routes')->findOneBy(array('routeId'=>$rId));
        $entity = new Intermediates();
        $entity->setRouteId($rId);
        $entity->setStopId($route->getEndStop());
        $entity->setstationNumber((int)$num);
        $form = $this->createCreateForm($entity);

        return $this->render('BuskoJourneyBundle:Intermediates:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Intermediates entity.
     *
     */
    public function showAction($id, $rId, Request $request) {
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BuskoEntityBundle:Intermediates')->findOneBy(array("stopId" => $id, "routeId" => $rId));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intermediates entity.');
        }

        $deleteForm = $this->createDeleteForm($id, $rId);

        return $this->render('BuskoJourneyBundle:Intermediates:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Intermediates entity.
     *
     */
    public function editAction($id, $rId) {
        $em = $this->getDoctrine()->getManager();


        $entity = $em->getRepository('BuskoEntityBundle:Intermediates')->findOneBy(array("stopId" => $id, "routeId" => $rId));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intermediates entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id, $rId);

        return $this->render('BuskoJourneyBundle:Intermediates:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
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
    private function createEditForm(Intermediates $entity) {
        $form = $this->createForm(new IntermediatesType(), $entity, array(
            'action' => $this->generateUrl('intermediates_update', array('id' => $entity->getStopId(), 'rId' => $entity->getRouteId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Intermediates entity.
     *
     */
    public function updateAction(Request $request, $rId, $id) {
        $em = $this->getDoctrine()->getManager();


        $entity = $em->getRepository('BuskoEntityBundle:Intermediates')->findOneBy(array("stopId" => $id, "routeId" => $rId));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Intermediates entity.');
        }

        $deleteForm = $this->createDeleteForm($id, $rId);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('intermediates_edit', array('id' => $id, 'rId' => $rId)));
        }

        return $this->render('BuskoJourneyBundle:Intermediates:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Intermediates entity.
     *
     */
    public function deleteAction(Request $request, $id, $rId) {



        $form = $this->createDeleteForm($id, $rId);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BuskoEntityBundle:Intermediates')->findOneBy(array("stopId" => $id, "routeId" => $rId));

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
    private function createDeleteForm($id, $rId) {
        //$rId=$request->get('rId');
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('intermediates_delete', array('id' => $id, 'rId' => $rId)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
