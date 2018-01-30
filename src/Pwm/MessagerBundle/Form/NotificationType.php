<?php

namespace Pwm\MessagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\ImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class NotificationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titre')
        ->add('sousTitre')
        ->add('text')
        ->add('tag')
        ->add('format', ChoiceType::class, array(
                                 'choices'  => array(
                                  'notifications' => 'Notifications', 'paper' => 'Annonce', 'alarm' => 'Alerte temps'),
                                   ))
        ->add('groupe', EntityType::class,
             array('class' => 'AdminBundle:Groupe', 
                   'choice_label' => 'getNom', 
                   'placeholder' => 'Tout le monde',
                   'empty_data'  => null,
                    'required' => false ,                  
                    'label'=>'Groupe')
             )
        ->add('includeMail')
        ->add('sendDate')
        ->add('sendNow');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pwm\MessagerBundle\Entity\Notification'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pwm_messagerbundle_notification';
    }


}
