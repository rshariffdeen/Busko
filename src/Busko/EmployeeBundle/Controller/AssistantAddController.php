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
use Busko\EntityBundle\Entity\Assistants;

/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class AssistantAddController extends Controller {

    public function registerAction(Request $request) {
        $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

        if (in_array("ADMIN", $user->getRoles())) {
            
        } else {
            if (in_array("OPERATOR", $user->getRoles())) {
                
            } else {

                return $this->forward('FOSUserBundle:Security:login');
            }
        }


        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $userManager->createUser();
        $phone = new EmployeePhones();
        $assistant = new Assistants();

        $user->setEnabled(true);
        $user->getPhone()->add($phone);

        $user->getAssistant()->add($assistant);
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            $user->addRole('ASSISTANT');
            $originalPhones = new ArrayCollection();
            $originalAssistants = new ArrayCollection();

            // Create an ArrayCollection of the current Tag objects in the database
            foreach ($user->getPhone() as $tag) {
                $originalPhones->add($tag);
            }
            foreach ($user->getAssistant() as $tag) {
                $originalAssistants->add($tag);
            }
            $em = $this->container->get('doctrine')->getEntityManager();
            if ($form->isValid()) {
                foreach ($originalPhones as $tag) {
                    $user->getPhone()->removeElement($tag);
                }
                foreach ($originalAssistants as $tag) {
                    $user->getAssistant()->removeElement($tag);
                }
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
            try {
                $userManager->updateUser($user);
                foreach ($originalPhones as $tag) {
                    $tag->setId($user->getId());
                    $em->persist($tag);
                    $em->flush();
                }
                foreach ($originalAssistants as $tag) {
                    $tag->setId($user);
                    $em->persist($tag);
                    $em->flush();
                }
            } catch (\Exception $e) {
                return $this->container->get('templating')->renderResponse('BuskoEmployeeBundle:Assistants:register.html.' . $this->getEngine(), array(
                            'form' => $form->createView(), 'type' => 'E', 'message' => 'exception! something was not right',
                ));
            }


            if (null === $response = $event->getResponse()) {




                $url = $this->container->get('router')->generate('site_emp');
                $response = new RedirectResponse($url);
            }

            //  $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }


        return $this->container->get('templating')->renderResponse('BuskoEmployeeBundle:Assistants:register.html.' . $this->getEngine(), array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user
     */
    protected function getEngine() {
        return $this->container->getParameter('fos_user.template.engine');
    }

}
