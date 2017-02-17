<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class EtapeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('date','datetime', array(
              'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'invalid_message' => 'Validation date',
                'error_bubbling' => true,
                'input' => 'datetime' # return a Datetime object (*)
            ))
       ->add('heure','datetime', array(
              'widget' => 'single_text',
                'format' => 'HH:mm',
                'invalid_message' => 'Validation date',
                'error_bubbling' => true,
                'input' => 'datetime' # return a Datetime object (*)
            ))
        ->add('latitude')
        ->add('longitude')
        ->add('type')
        ->add('user', EntityType::class, array('class' => 'AppBundle:Client'))
        ->add('suivant',EtapeSuivantType::class, array()) ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Etape',
             'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_etape';
    }


}
