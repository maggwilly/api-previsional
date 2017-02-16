<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class VisiteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('map')
        ->add('pre')
        ->add('aff')
        ->add('exc')
        ->add('vpt')
        ->add('sapp')
        ->add('commentaire')
        ->add('fp')
        ->add('rpp')
        ->add('rpd')
        ->add('date')
        ->add('situations',CollectionType::class, array('entry_type'=> SituationType::class,'allow_add' => true))
        ->add('pointVente', EntityType::class, array('class' => 'AppBundle:PointVente'))
        ->add('user', EntityType::class, array('class' => 'AppBundle:Client'))        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Visite',
                'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_visite';
    }


}
