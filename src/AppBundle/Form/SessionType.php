<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class SessionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom')
        ->add('nomConcours','text')
        ->add('abreviation')
        ->add('serie', ChoiceType::class, array(
                                  'choices'  => array(
                                         '' => 'Toute series',
                                         'science' => 'science',
                                         'Lettres' => 'Lettres',
                                         'economie' => 'economie', 
                                         'droit' => 'droit', 
                                         'technique' => 'technique'),
                                   ))
        ->add('niveau', ChoiceType::class, array(
                                  'choices'  => array(
                                         '' => 'Tous les niveaux',
                                         'CEPE' => 'CEPE',
                                         'BEPC - GCE O/L' => 'BEPC - GCE O/L',
                                         'BAC - GCE A/L' => 'BAC - GCE A/L', 
                                         'Licence & equiv' => 'Licence & equiv', 
                                         'Master & equiv' => 'Master & equiv'),
                                   ))
        ->add('dateMax', 'date', array('years' => range(1980, 2035), 'format' => 'dd-MMMM-yyyy'))        
        ->add('price')
        ->add('nombrePlace')
        ->add('nombreInscrit')
        ->add('dateLancement')
        ->add('dateConcours')
        ->add('archived')
        ->add('dateDossier')
        ->add('type', ChoiceType::class, array(
                                 'choices'  => array(
                                  'écrit' => 'Epreuves écrites', 'direct' => 'Etude de dossier', 'sport' => 'Epreuves sportives'),
                                   ))
        ->add('price', EntityType::class,
             array('class' => 'AdminBundle:Price', 
                   'choice_label' => 'nom', 
                   'empty_data' => null,
                   'label'=>'Tarif')
             )        
        ->add('preparation', EntityType::class,
             array('class' => 'AppBundle:Programme', 
                   'choice_label' => 'nom', 
                   'placeholder' => 'Please choose',
                   'empty_data'  => null,
                    'required' => false
                   'label'=>'Progrmme de prépa')
             );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Session'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_session';
    }


}
