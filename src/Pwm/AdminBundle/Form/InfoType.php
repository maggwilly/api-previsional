<?php

namespace Pwm\AdminBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Pwm\MessagerBundle\Form\RegistrationType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class InfoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('displayName')
        ->add('email')
        ->add('uid')
        ->add('photoURL')
        ->add('langue')
        ->add('phone')
        ->add('ville')
        ->add('serie')
        ->add('niveau')
        ->add('dateMax','datetime', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'invalid_message' => 'Validation date',
                'error_bubbling' => true,
                'input' => 'datetime' # return a Datetime object (*)
            ))        
        ->add('branche')
        ->add('paymentMethod')
        ->add('enableNotifications');        
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
     $resolver->setDefaults(array(
            'data_class' => 'Pwm\AdminBundle\Entity\Info',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_info';
    }


}
