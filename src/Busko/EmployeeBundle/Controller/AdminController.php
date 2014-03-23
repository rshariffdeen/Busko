<?php

namespace Busko\EmployeeBundle\Controller;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

use Busko\EntityBundle\Entity\EmployeePhones;
use Doctrine\Common\Collections\ArrayCollection;
use Busko\EntityBundle\Entity\Administrators;
use Busko\EntityBundle\Entity\Employees;


/**
 * Operators controller.
 *
 */
class AdminController extends Controller
{

    /**
     * Lists all Operators entities.
     *
     */
    public function indexAction(Request $request) {
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

                    'type'=>$request->get('type'),'message'=>$request->get('message') ,
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
        $entity = new Employees();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($entity);
            try{
            $em->flush();
            }
            catch(\Exception $e){
                return $this->render('BuskoStyleBundle:Error:error.html.twig', array('message'=>' Administrator cannot be added. Make sure details are unique'));      
            }

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
                return $this->render('BuskoStyleBundle:Error:error.html.twig', array('message'=>' Administrator could not be deleted'));      
            }
                return $this->redirect($this->generateUrl('site_emp', array('type'=>'S','message' => "Succesfully removed Administrator")));
            }

            if (!$employee) {
                return $this->redirect($this->generateUrl('site_emp', array('type'=>'E','message' => "Administrator Not Found")));
            }
        }

        return $this->redirect($this->generateUrl('site_emp', array('message' => "Oops! something went wrong",'type'=>'E')));
     }
     
     public function registerAction(Request $request) {
        
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
            $user->addRole('ADMIN');
            $userManager->updateUser($user);
            $admin=new Administrators();
            foreach ($originalPhones as $tag) {
                $tag->setId($user->getId());
                $em->persist($tag);
                $em->flush();
            } 
            $admin->setId($user);
            $em->persist($admin);
             $em->flush();

            if (null === $response = $event->getResponse()) {
                
                $url = $this->container->get('router')->generate('site_emp',array('type'=>'S','message'=>'successfully added new Admin '));
                $response = new RedirectResponse($url);
            }
            
            

            //  $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }


        return $this->container->get('templating')->renderResponse('BuskoEmployeeBundle:Administrators:register.html.' . $this->getEngine(), array(
                    'form' => $form->createView(), 
        ));
    }
    protected function getEngine() {
        return $this->container->getParameter('fos_user.template.engine');
    }


   
}