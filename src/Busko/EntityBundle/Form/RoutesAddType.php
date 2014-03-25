<?php

namespace Busko\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RoutesAddType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
       $builder->add('stop', 'collection', array('type' => new \Busko\EntityBundle\Form\IntermediatesAddType()));
       $builder->add('submit', 'submit', array(
            'label' => 'Save and Next'))
        ;
            
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Busko\EntityBundle\Entity\RoutesAdd'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'busko_entitybundle_routesAdd';
    }
}
