<?php

namespace Busko\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DrivesUpdateType extends AbstractType
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
            'date',
            'date',array(
                'label' => 'Date',
                'widget'=> 'single_text',
                'format' => 'yyyy-MM-dd',
            )    );
              
        $builder->add('submit', 'submit', array(
            'label' => 'Update'))
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Busko\EntityBundle\Entity\DrivesUpdate'
        ));
    }

    public function getName()
    {
        return 'HR_Assignment';
    }
}
?>
