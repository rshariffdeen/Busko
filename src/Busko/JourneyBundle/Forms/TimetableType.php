<?php

namespace Busko\JourneyBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class TimetableType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           
     
        $builder->add('StartBusStop', 'entity', array(
            'label' =>'Source',
            'class' => 'BuskoEntityBundle:BusStops',
            
            'property' => 'city',
            'label_attr' => array('class' => 'control-label'),
            'attr' => array(
            'class' =>'controls',
                'data-rel'=>'chosen'
                )
            ));
        
        $builder->add('StopBusStop', 'entity', array(
            'label' =>'Destination',
            'label_attr' => array('class' => 'control-label'),
            'attr' => array(
            'class' =>'controls',
                'data-rel'=>'chosen'
                )
            ,
            'class' => 'BuskoEntityBundle:BusStops',
            'property' => 'city',
            ));
       
        $builder 
            ->add('date','text',array(
           
            'label_attr' => array('class' => 'control-label'),
                 'label' =>'Date',
                  
                'attr'=>array(
                    'placeholder'=>'date',
                    'class' => 'input-xlarge datepicker',
                    'data'  => \Date('today'),
                    )
            ));
        $builder 
            ->add('from','time',array(
            //'choices'   => array(0 => 00, 1 => 01, 2 => 02, 3 => 03, 4 => 04, 5 => 05, 6 => 06, 7 => 07, 8 => 08, 9 => 09, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21, 22 => 22, 23 => 23),    
            'label' =>'From',
            'widget'=>'choice',
                'with_minutes'=>false,
                'label_attr' => array('class' => 'control-label'),
            
                'attr'=>array()
            ));
        $builder 
            ->add('to','time',array(
            'label' =>'To',
            'widget'=>'choice',
            'with_minutes'=>false,
                'label_attr' => array('class' => 'control-label'),
            ));
        $builder 
            ->add('submit','submit', array(
                'label' => 'Search',
                'attr' => array(
                    'class' => 'btn btn-primary'
                    
                )
                
            ));
      
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     *
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VolunteerManagementSystem\ProjectBundle\Entity\Project'
        ));
    }
    */
    /**
     * @return string
     */
    public function getName()
    {
        return 'Busko';
    }
}

?>


<?php

