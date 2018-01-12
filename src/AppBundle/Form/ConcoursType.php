<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class ConcoursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom')
        ->add('ecole')
        ->add('abreviation')
        ->add('descriptionEcole')
        ->add('descriptionConcours')
        ->add('serie', ChoiceType::class, array(
                                  'choices'  => array(
                                         'science' => 'science',
                                         'Lettres' => 'Lettres',
                                         'economie' => 'economie', 
                                         'droit' => 'droit', 
                                         'technique' => 'technique'),
                                   ))
        ->add('niveau', ChoiceType::class, array(
                                  'choices'  => array(
                                         'CEPE' => 'CEPE',
                                         'BEPC - GCE O/L' => 'BEPC - GCE O/L',
                                         'BAC - GCE A/L' => 'BAC - GCE A/L', 
                                         'Licence & equiv' => 'Licence & equiv', 
                                         'Master & equiv' => 'Master & equiv'),
                                   ))
        ->add('dateMax', 'date', array('years' => range(1980, 2035), 'format' => 'dd-MMMM-yyyy'))    
        ->add('contacts')
        ->add('imageUrl')
        ->add('imageEntity',   new ImageType(), array('label'=>'Image de la question','required'=>false));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Concours'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_concours';
    }


}
