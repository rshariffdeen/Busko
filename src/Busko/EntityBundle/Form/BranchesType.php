<?php

namespace Busko\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Busko\EntityBundle\Entity\BusStops;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BranchesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
//           $em = $this->getDoctrine()->getManager();
//           $i=0;$cit;
//           $entity = $em->getRepository('BuskoEntityBundle:BusStops')->findAll();
//           foreach ($entity as $en){
//               $cit[$i]=$en->getCity();
//               ++$i;
//           }
           
           $builder
            ->add('branchId', 'text', array( 
            'label'  => 'Branch ID',
            'attr'  => array(
               'placeholder' =>'type branch ID' 
            )
            ));
            $builder
            ->add('phone', 'text', array( 
            'label'  => 'Phone Number',
            'attr'  => array(
               'placeholder' =>'type phone Number' 
            )
            ));
             $builder
            ->add('streetno', 'text', array( 
            'label'  => 'Street Number',
            'attr'  => array(
               'placeholder' =>'type Street Number' 
            )
            ));
             $builder
            ->add('street', 'text', array( 
            'label'  => 'Street',
            'attr'  => array(
               'placeholder' =>'type Street' 
            )
            ));
//                         $builder
//                         ->add('city', 'choice', array( 
//            'choices'  => array($cit),
//           
//            'attr'  => array(
//               'placeholder' =>'type City' 
//            )
//            ));
                                  $builder
            ->add('city', 'entity', array( 
            'label'  => 'City',
            'class' => 'BuskoEntityBundle:BusStops',
            'property' => 'city',
            'attr'  => array(
               'placeholder' =>'type City' 
            )
            ));
              $builder 
                ->add('submit','submit', array(
                'label' => 'Create Branch',
                'attr' => array(
                    'class' => 'button'
                )
                
            ));
          
            
        ;
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Busko\EntityBundle\Entity\Branches'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'busko_entitybundle_branches';
    }
}
?>
<?php





  
