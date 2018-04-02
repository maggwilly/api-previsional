<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
        ->add('ville')
        ->add('username')
        ->add('email')
        ->add('roles', ChoiceType::class, array(
                                  'choices'  => array(
                                  'ROLE_SAISIE' => 'Editeur/correcteur',
                                   'ROLE_AMBASSADOR' => 'Ambassadeur',
                                   'ROLE_SUPERVISEUR' => 'Superviseur',
                                   'ROLE_MESSAGER' => 'Push Messager',
                                   'ROLE_CONTROLEUR' => 'Controleur',
                                   'ROLE_ADMIN' => 'Administrateur'
                                   ), 
                                  'multiple'=>true,
                                  'expanded'=>false,
                                  'attr'=>array('data-rel'=>'chosen'),
                                   ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
