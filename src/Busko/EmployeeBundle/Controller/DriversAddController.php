<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
use Busko\EntityBundle\Form\EmployeePhonesType;
use Busko\EntityBundle\Entity\EmployeePhones;
use Doctrine\Common\Collections\ArrayCollection;
use Busko\EntityBundle\Entity\Drivers;

/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class DriversAddController extends Controller {

    public function registerAction(Request $request) {
         $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

        if (in_array("ADMIN", $user->getRoles())) {
            
        }else {
            if (in_array("OPERATOR", $user->getRoles())) {
            }else{
        
                 return $this->forward('FOSUserBundle:Security:login');
        } }
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $userManager->createUser();
        $phone = new EmployeePhones();
        $driver=new Drivers();

        $user->setEnabled(true);
        $user->getPhone()->add($phone);

        $user->getDriver()->add($driver);
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            $user->addRole('DRIVER');
            $originalPhones = new ArrayCollection();
            $originalDrivers = new ArrayCollection();

            // Create an ArrayCollection of the current Tag objects in the database
            foreach ($user->getPhone() as $tag) {
                $originalPhones->add($tag);
            }
            foreach ($user->getDriver() as $tag) {
                $originalDrivers->add($tag);
            }
            $em = $this->container->get('doctrine')->getEntityManager();
            if ($form->isValid()) {
                foreach ($originalPhones as $tag) {
                    $user->getPhone()->removeElement($tag);
                }
                foreach ($originalDrivers as $tag) {
                    $user->getDriver()->removeElement($tag);
                }
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $userManager->updateUser($user);
            foreach ($originalPhones as $tag) {
                $tag->setId($user->getId());
                $em->persist($tag);
                $em->flush();
            }
            foreach ($originalDrivers as $tag) {
                $tag->setId($user);
                $em->persist($tag);
                $em->flush();
            }

            if (null === $response = $event->getResponse()) {
                


                
              $url = $this->container->get('router')->generate('site_emp');
              $response = new RedirectResponse($url);
            }

            //  $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }


        return $this->container->get('templating')->renderResponse('BuskoEmployeeBundle:Drivers:register.html.' . $this->getEngine(), array(
                    'form' => $form->createView(), 'form1' => $form->createView(),
        ));
    }

    /**
     * Tell the user to check his email provider
     */
   

    /**
     * Receive the confirmation token from user email provider, login the user
     */
    public function confirmAction(Request $request, $token) {

        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

       
        $dispatcher = $this->container->get('event_dispatcher');

        $user->setConfirmationToken(null);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->container->get('router')->generate('fos_user_registration_confirmed');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction() {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:confirmed.html.' . $this->getEngine(), array(
                    'user' => $user,
        ));
    }

    protected function getEngine() {
        return $this->container->getParameter('fos_user.template.engine');
    }

}
