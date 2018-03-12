<?php

namespace Pwm\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('price')
        ->add('nom')
        ->add('description')
        ->add('detail1')
        ->add('detail2')
        ->add('detail3')
        ->add('detail4')
        ->add('style')
        ->add('size')        
        ->add('url')
        ->add('imageUrl')
        ->add('isPublic');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pwm\AdminBundle\Entity\Ressource'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pwm_adminbundle_ressource';
    }


}
