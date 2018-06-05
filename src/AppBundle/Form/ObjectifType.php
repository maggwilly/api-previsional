<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class ObjectifType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
        ->add('description', UrlType::class, array(
            'label' => 'Lien direct',)) 
        ->add('sessions', EntityType::class,array('class' => 'AppBundle:Session', 
                           'choice_label' => 'nomConcours', 
                           'placeholder' => 'Toute les sessions',
                            'empty_data'  => null,
                            'required' => false,
                            'label'=>'Selectionnez les concours',      
                            'multiple'=>true,
                            'expanded'=>false,                  
                            'attr'=>array('data-rel'=>'chosen'))) ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Objectif'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_objectif';
    }


}
