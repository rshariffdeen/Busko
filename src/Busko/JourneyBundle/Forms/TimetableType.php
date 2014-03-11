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
            'label' =>'From',
            'class' => 'BuskoEntityBundle:BusStops',
            'property' => 'city',
            ));
        
        $builder->add('StopBusStop', 'entity', array(
            'label' =>'From',
            'class' => 'BuskoEntityBundle:BusStops',
            'property' => 'city',
            ));
       
        $builder 
            ->add('date','date',array(
            'label' =>'date',
            'widget'=>'choice',
                'attr'=>array(
                    'placeholder'=>'date'
                    
                    )
            ));
        $builder 
            ->add('from','time',array(
            'label' =>'From',
            'widget'=>'choice',
                'attr'=>array(
                    'placeholder'=>'from'
                    )
            ));
        $builder 
            ->add('to','time',array(
            'label' =>'to',
            'widget'=>'choice',
                'attr'=>array(
                    'placeholder'=>'to'
                    )
            ));
        $builder 
         ->add('submit','submit', array(
                'label' => 'go!!!',
                'attr' => array(
                    'class' => 'button'
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

