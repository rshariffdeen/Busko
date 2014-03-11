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
                    )
            ));
        $builder 
            ->add('from','time',array(
            'label' =>'From',
            'widget'=>'choice',
                'with_minutes'=>'false',
                'label_attr' => array('class' => 'control-label'),
            
                'attr'=>array(
                    'placeholder'=>'Starting Time',
                       
                 
                    )
            ));
        $builder 
            ->add('to','time',array(
            'label' =>'to',
            'widget'=>'choice',
                'label_attr' => array('class' => 'control-label'),
                'attr'=>array(
                    'placeholder'=>'Until'
                    )
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

