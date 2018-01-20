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
        ->add('text')->add('sousTitre')
        ->add('format', ChoiceType::class, array(
                                 'choices'  => array(
                                  'html' => 'HTML', 'math' => 'MATH', 'text' => 'TEXT'),
                                   ))
        ->add('session', EntityType::class,
             array('class' => 'AppBundle:Session', 
                   'choice_label' => 'getNomConcours', 
                   'placeholder' => 'Please choose',
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
