<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class ProgrammeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
        ->add('ecole')
        ->add('abreviation')
        ->add('type')
        ->add('session')
        ->add('descriptionEcole')
        ->add('descriptionConcours')
        ->add('nombrePlace')
        ->add('dateConcours')
        ->add('dateDossier')
        ->add('lien')
        ->add('image')
        ->add('contact')
        ->add('auMoinsdeMemeQue', EntityType::class, array('class' => 'AppBundle:Programme',   'choice_label' => 'nom', 'empty_data' => '--','label'=>'Le même programme  que'))
        ->add('resultats') ;
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
