<?php

namespace Busko\EmployeeBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('first_name');
        $builder->add(
            'branchId',
            'entity',array(
                'label' => 'select driver',
                'class' => 'BuskoEntityBundle:Branches',
                'property' => 'branchId',
                'query_builder' => function(EntityRepository $er) {
                                    return $er->createQueryBuilder('p')
                                              ->orderBy('p.branchId', 'ASC');
                                   }
            )    );
        $builder->add('last_name');
        $builder->add('street_no');
        $builder->add('street');
        $builder->add('city');
        $builder->add('roles', 'collection', array(
        'type'   => 'choice',
        'options'  => array(
            'choices'  => array(
                'admin' => 'Admin',
                'Driver'     => 'Driver',
                'assistant'    => 'Assistant',
                'operator'    => 'Operator',
            ),
        ),
));
    }
     public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Busko\EntityBundle\Entity\Employees'
        ));
    }


    public function getName()
    {
        return 'groundZero_user_profile';
    }
}