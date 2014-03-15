<?php

namespace Busko\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BusesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('capacity')
            ->add('model')
            ->add('conditions')
            ->add('branch')
            ->add('route')
        ;
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
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Busko\EntityBundle\Entity\Buses'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'busko_entitybundle_buses';
    }
}
