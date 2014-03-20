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
class EmployeeController extends Controller
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
         $operators = $query->getResult();
        /* $query1 = $repository->createQueryBuilder('a')
                ->where('a.roles LIKE :title')
                ->setParameter('title', '%ADMIN%')
                ->getQuery();
         $admins = $query1->getResult();
         $query2 = $repository->createQueryBuilder('a')
                ->where('a.roles LIKE :title')
                ->setParameter('title', '%DRIVER%')
                ->getQuery();
         $drivers = $query2->getResult();
         $query3 = $repository->createQueryBuilder('a')
                ->where('a.roles LIKE :title')
                ->setParameter('title', '%ASSISTANT%')
                ->getQuery();
         $assistants = $query3->getResult();
        
*/
        return $this->render('BuskoEmployeeBundle:Employee:index.html.twig', array(
                  //  'drivers' => $drivers,'operators' => $operators,'admins' => $admins,'assistants' => $assistants,
            
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
        
        $entity = $em->getRepository('BuskoEntityBundle:Employees')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Operators entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BuskoEmployeeBundle:Operators:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
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
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserByUsername($id);
        $id2 = $user->getId();
        $entity = $em->getRepository('BuskoEntityBundle:Operators')->find($id2);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Operators entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('operators_edit', array('id' => $id)));
        }

        return $this->render('BuskoEmployeeBundle:Operators:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Operators entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BuskoEntityBundle:Employees')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Operators entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('operators'));
    }

    /**
     * Creates a form to delete a Operators entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('operators_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
