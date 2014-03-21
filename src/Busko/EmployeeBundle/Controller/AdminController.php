<?php

namespace Busko\EmployeeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Busko\EntityBundle\Entity\Operators;
use Busko\EntityBundle\Form\OperatorsType;

/**
 * Operators controller.
 *
 */
class AdminController extends Controller{

    /**
     * Lists all Operators entities.
     *
     */
    public function indexAction() {
        $user =  $this->getUser();
        if (in_array("ADMIN", $user->getRoles())) {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('BuskoEntityBundle:Employees');

        $query = $repository->createQueryBuilder('a')
                ->where('a.roles LIKE :title')
                ->setParameter('title', '%OPERATOR%')
                ->getQuery();
         


        $entities = $query->getResult();
        // $entities = $em->getRepository('BuskoEntityBundle:Operators')->findAll();


        return $this->render('BuskoEmployeeBundle:OPerators:index.html.twig', array(


                    'entities' => $entities,
            
        ));
    }
    }

    /**
     * Creates a new Operators entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Operators();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('operators_show', array('id' => $entity->getId())));
        }

        return $this->render('BuskoEmployeeBundle:Operators:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            
        ));
    }

    /**
    * Creates a form to create a Operators entity.
    *
    * @param Operators $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Operators $entity)
    {
        $form = $this->createForm(new OperatorsType(), $entity, array(
            'action' => $this->generateUrl('operators_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Operators entity.
     *
     */
  

    /**
     * Finds and displays a Operators entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $profile = $em->getRepository('BuskoEntityBundle:Employees')->find($id);
        if (!$profile) {
            throw $this->createNotFoundException('Unable to find Operators entity.');
        }

      
        return $this->render('BuskoEmployeeBundle:Administrators:show.html.twig', array(
            'profile'      => $profile,
            ));
    }

    /**
     * Displays a form to edit an existing Operators entity.
     *
     */
   


    /**
    * Creates a form to edit a Operators entity.
    *
    * @param Operators $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    
    /**
     * Edits an existing Operators entity.
     *
     */
    
    /**
     * Deletes a Operators entity.
     *
     */
    public function deleteAction(Request $request)
    {
         $id = $request->get('id');

        if (!$id) {
            return $this->redirect($this->generateUrl('site_emp', array('message' => "Oops! something went wrong",'type'=>'E')));
        }
            $em = $this->getDoctrine()->getManager();
            $employee = $em->getRepository('BuskoEntityBundle:Employees')->find($id);
            
            if (!$employee) {
                return $this->render('BuskoStyleBundle:Error:error.html.twig',array('message'=>'Administrator Not Found'));
               }
            
          
                try{
                $em->remove($employee);                
                $em->flush();
                }
                
                catch (\Exception $e){
                    return $this->render('BuskoStyleBundle:Error:error.html.twig',array('message'=>'User Cannot be Deleted.'));
                }
                return $this->redirect($this->generateUrl('site_emp', array('type'=>'S','message' => "Succesfully removed Administrator")));
            

            
        }

 

    /**
     * Creates a form to delete a Operators entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
   
}
