<?php
namespace Busko\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RepairsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
               
                ->add('licNum','entity',array(
                'label' =>'Source',
            'class' => 'BuskoEntityBundle:Buses',            
            'property' => 'licNum',
            'label_attr' => array('class' => 'control-label'),
            'attr' => array(
            'class' =>'controls',
                'data-rel'=>'chosen'
                )
            ))
          /*persist date*/
             ->add('startDate','date',array(
            'label' =>'Start Date',
            'widget'=>'single_text'
            ))
            ->add('description','textarea')
            ->add('amount')
            
           
            ->add('repairState', 'choice', array(
    'choices' => array(
        'UNDER REPAIR' => 'UNDER REPAIR',
        'REPAIRED'=>'REPAIRED'
    )))
                ->add('submit','submit', array(
                'label' => 'Add Repair',
                'attr' => array(
                    'class' => 'button'
                )))
          
            
        ;;
          
            
        
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Busko\EntityBundle\Entity\Repairs'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'busko_entitybundle_repairs';
    }
}
?>
<?php





  
