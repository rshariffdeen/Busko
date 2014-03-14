<?php

namespace Busko\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DrivesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'licNum',
            'entity',array(
                'label' => 'Bus',
                'class' => 'BuskoEntityBundle:Buses',
                'property' => 'lic_num',
                'query_builder' => function(EntityRepository $er) {
                                    return $er->createQueryBuilder('p');
                                   }
            )    )
               ->add(
            'driv',
            'entity',array(
                'label' => 'Driver',
                'class' => 'BuskoEntityBundle:Drivers',
                'property' => 'id',
                'query_builder' => function(EntityRepository $er) {
                                    return $er->createQueryBuilder('p')
                                              ->orderBy('p.id', 'ASC');
                                   }
            )    )
              ->add(
            'ass',
            'entity',array(
                'label' => 'Assistant',
                'class' => 'BuskoEntityBundle:Assistants',
                'property' => 'id',
                'query_builder' => function(EntityRepository $er) {
                                    return $er->createQueryBuilder('p')
                                             ->orderBy('p.id', 'ASC');
                                   }
            )    );
            
            
            
            
            
        $builder->add('submit', 'submit', array(
            'label' => 'Set'))
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Busko\EntityBundle\Entity\Drives'
        ));
    }

    public function getName()
    {
        return 'HR_Assignment';
    }
}
?>
