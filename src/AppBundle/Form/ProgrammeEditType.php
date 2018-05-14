<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class ProgrammeEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom','text',array('label'=>'Nom du Programme'))
        ->add('abreviation','textarea',array('label'=>'Brève description '))
       /* ->add('auMoinsdeMemeQue', 
            EntityType::class,
             array('class' => 'AppBundle:Programme',
                'choice_label' => 'nom', 
                'label'=>'Selectionnez un programme', 'empty_data' => null,
                'placeholder' => 'Aucun ',
                'required' => false ,               
                'empty_data' => null)
             )*/
 ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Programme'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_programme';
    }


}
