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
            ->add('licNum','text')
            ->add('capacity')
            ->add('model')
           
            ->add('conditions', 'choice', array(
    'choices' => array(
        'GOOD' => 'GOOD',
        'UNDER REPAIR' => 'UNDER REPAIR',
        'NEEDS REPAIR'=>'NEEDS REPAIR',
        'BAD'=>'BAD'
    )))
            ->add('branch','entity',array(
                'label' =>'Source',
            'class' => 'BuskoEntityBundle:Branches',            
            'property' => 'branchId',
            'label_attr' => array('class' => 'control-label'),
            'attr' => array(
            'class' =>'controls',
                'data-rel'=>'chosen'
                )
                
            ))
            ->add('route','entity',array(
                'label' =>'Source',
            'class' => 'BuskoEntityBundle:Routes',            
            'property' => 'routeId',
            'label_attr' => array('class' => 'control-label'),
            'attr' => array(
            'class' =>'controls',
                'data-rel'=>'chosen'
                )
                
            ))
            
        ;
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
