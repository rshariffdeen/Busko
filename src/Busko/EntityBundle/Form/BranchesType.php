<?php

namespace Busko\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BranchesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
            
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
             $builder
            ->add('city', 'text', array( 
            'label'  => 'City',
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





  
