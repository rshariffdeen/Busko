<?php

namespace Busko\JourneyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class Date1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'dueDate',
            'date',array(
                'label' => 'Date',
                'widget' => 'single_text',
                //'format' => 'yyyy-MM-dd',
               //'attr'=> array( 'class' => 'input-xlarge datepicker')
            ));
            
            
            
            
            
        $builder->add('submit', 'submit', array(
            'label' => 'Set'))
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Busko\JourneyBundle\Entity\Date1'
        ));
    }

    public function getName()
    {
        return 'HR_Assignment';
    }
}
?>
