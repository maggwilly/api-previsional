<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PartieEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('sessions', EntityType::class,
                       array('class' => 'AppBundle:Session', 
                           'choice_label' => 'nomConcours', 
                           'placeholder' => 'Toute les sessions',
                            'empty_data'  => null,
                            'required' => false,
                            'label'=>'Selectionnez les concours',      
                            'multiple'=>true,
                            'expanded'=>false,                  
                            'attr'=>array('data-rel'=>'chosen')));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Partie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_partie';
    }


}