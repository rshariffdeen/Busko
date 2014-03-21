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
class DriversController extends Controller {

    /**
     * Lists all Drivers entities.
     *
     */
    public function indexAction() {
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
    public function createAction(Request $request) {
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
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Drivers entity.
     *
     * @param Drivers $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Drivers $entity) {
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
    public function newAction() {
        $entity = new Drivers();
        $form = $this->createCreateForm($entity);

        return $this->render('BuskoEmployeeBundle:Drivers:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Drivers entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserByUsername($id);
        $id = $user->getId();
        $details = $em->getRepository('BuskoEntityBundle:Drivers')->find($id);
        $profile = $em->getRepository('BuskoEntityBundle:Employees')->find($id);
        if (!$details) {
            throw $this->createNotFoundException('Unable to find Drivers entity.');
        }

       

        return $this->render('BuskoEmployeeBundle:Drivers:show.html.twig', array(
                    'driver' => $details,
                    'profile' => $profile,
                    ));
    }

    /**
     * Displays a form to edit an existing Drivers entity.
     *
     */
    

    /**
     * Creates a form to edit a Drivers entity.
     *
     * @param Drivers $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Drivers $entity) {
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
    
    /**
     * Deletes a Drivers entity.
     *
     */
    public function deleteAction(Request $request) {

        $id = $request->get('id');

        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $driver = $em->getRepository('BuskoEntityBundle:Drivers')->find($id);
            $employee = $em->getRepository('BuskoEntityBundle:Employees')->find($id);
            
            if ($employee) {
                $em->remove($employee);
                $em->remove($driver);
                $em->flush();
                return $this->redirect($this->generateUrl('site_emp', array('type'=>'S','message' => "Succesfully removed Driver")));
            }

            if (!$employee) {
                return $this->redirect($this->generateUrl('site_emp', array('type'=>'E','message' => "Driver Not Found")));
            }
        }

        return $this->redirect($this->generateUrl('site_emp', array('message' => "Oops! something went wrong",'type'=>'E')));
    }

    /**
     * Creates a form to delete a Drivers entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    

}
