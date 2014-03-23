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
            'type'=>$request->get('type'),'message'=>$request->get('message') 
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
          try{
            $em->flush();

            }
            
            catch(\Exception $e){
                 return $this->render('BuskoEmployeeBundle:Assistants:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'type' => 'E',
                    'message' => 'something was not right'
        ));
            }

           return $this->forward('BuskoSiteBundle:Admin:employee', array(
                    'type' => 'S',
                    'message' => 'successfully added new assistant',
        )); }

        return $this->render('BuskoEmployeeBundle:Assistants:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'type' => 'E',
                    'message' => 'something was not right',
                   
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
    public function newAction(Request $request) {
        $entity = new Assistants();
        $form = $this->createCreateForm($entity);

        return $this->render('BuskoEmployeeBundle:Assistants:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'id'    => $request->get('id')
            
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
        $details = $em->getRepository('BuskoEntityBundle:Assistants')->find($id);
        $profile = $em->getRepository('BuskoEntityBundle:Employees')->find($id);
        if (!$details) {
            throw $this->createNotFoundException('Unable to find Assistants entity.');
        }

       
        return $this->render('BuskoEmployeeBundle:Assistants:show.html.twig', array(
                    'assistant' => $details,
                    'profile'   => $profile,
                    ));
    }

    /**
     * Displays a form to edit an existing Assistants entity.
     *
     */
   

    /**
     * Creates a form to edit a Assistants entity.
     *
     * @param Assistants $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
 

    /**
     * Edits an existing Assistants entity.
     *
     */
   

    /**
     * Deletes a Assistants entity.
     *
     */
    public function deleteAction(Request $request) {
        $id = $request->get('id');

        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $assistant = $em->getRepository('BuskoEntityBundle:Assistants')->find($id);
            $employee = $em->getRepository('BuskoEntityBundle:Employees')->find($id);
            
            if ($employee) {
                $em->remove($employee);
                $em->remove($assistant);
                try{
                $em->flush();
                }
                
                catch(\Exception $e){
                return $this->render('BuskoStyleBundle:Error:error.html.twig', array('message'=>' Assistant could not be deleted. Make sure he/she is not assigned for future tasks'));      
            }
                return $this->redirect($this->generateUrl('site_emp', array('type'=>'S','message' => "Succesfully removed Assistant")));
            }

            if (!$employee) {
                return $this->redirect($this->generateUrl('site_emp', array('type'=>'E','message' => "Assistant Not Found")));
            }
        }

        return $this->redirect($this->generateUrl('site_emp', array('message' => "Oops! something went wrong",'type'=>'E')));
     }

    /**
     * Creates a form to delete a Assistants entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
   

}
