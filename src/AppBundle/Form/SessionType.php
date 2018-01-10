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
        ->add('nomConcours')
        ->add('abreviation')
        ->add('serie')
        ->add('niveau')
        ->add('dateMax')        
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
                   'empty_data' => null,
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
