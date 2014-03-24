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
use Busko\EntityBundle\Form\EmployeePhonesType;
use Busko\EntityBundle\Entity\EmployeePhones;
use Doctrine\Common\Collections\ArrayCollection;
use Busko\EntityBundle\Entity\Operators;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Busko\EntityBundle\Entity\Employees;
use Busko\EntityBundle\Form\EmployeeType;

/**
 * Operators controller.
 *
 */
class OperatorController extends Controller
{

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
            'type'=>$request->get('type'),'message'=>$request->get('message') 
            
        ));
    }
    }

    /**
     * Creates a new Operators entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Employees();
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

     

        return $this->render('BuskoEmployeeBundle:Operators:show.html.twig', array(
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
    private function createEditForm(Operators $entity)
    {
        $form = $this->createForm(new OperatorsType(), $entity, array(
            'action' => $this->generateUrl('operators_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
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

        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $employee = $em->getRepository('BuskoEntityBundle:Employees')->find($id);
            
            if ($employee) {
                $em->remove($employee);
                try{
                $em->flush();
                }
                catch(\Exception $e){
                return $this->render('BuskoStyleBundle:Error:error.html.twig', array('message'=>' Operator could not be deleted.'));      
            }
                return $this->redirect($this->generateUrl('site_emp', array('type'=>'S','message' => "Succesfully removed Operator")));
            }

            if (!$employee) {
                return $this->redirect($this->generateUrl('site_emp', array('type'=>'E','message' => "Operator Not Found")));
            }
        }

        return $this->redirect($this->generateUrl('site_emp', array('message' => "Oops! something went wrong",'type'=>'E')));
    
    }
      
     public function registerAction(Request $request) {
         $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

        if (!(in_array("ADMIN", $user->getRoles()))) {
           return $this->forward('FOSUserBundle:Security:login');
        }
        
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $userManager->createUser();
        $phone = new EmployeePhones();
        

        $user->setEnabled(true);
        $user->getPhone()->add($phone);

        //$user->getDriver()->add($driver);
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            $originalPhones = new ArrayCollection();

            // Create an ArrayCollection of the current Tag objects in the database
            foreach ($user->getPhone() as $tag) {
                $originalPhones->add($tag);
            }
            $em = $this->container->get('doctrine')->getEntityManager();
            if ($form->isValid()) {
                foreach ($originalPhones as $tag) {
                    $user->getPhone()->removeElement($tag);
                }
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
            $user->addRole('OPERATOR');
            $operator=new Operators();
            $userManager->updateUser($user);
           
            foreach ($originalPhones as $tag) {
                $tag->setId($user->getId());
                $em->persist($tag);
                $em->flush();
            }
            
            $operator->setId($user);
            $em->persist($operator);
            $em->flush();

            if (null === $response = $event->getResponse()) {
                
                
                $url = $this->container->get('router')->generate('site_emp',array('type'=>'S','message'=>'successfully added new Operator '));
                $response = new RedirectResponse($url);
            }
            
            

            //  $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }


        return $this->container->get('templating')->renderResponse('BuskoEmployeeBundle:Operators:register.html.' . $this->getEngine(), array(
                    'form' => $form->createView(), 
        ));
    }
    protected function getEngine() {
        return $this->container->getParameter('fos_user.template.engine');
    }


    /**
     * Creates a form to delete a Operators entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    
}
