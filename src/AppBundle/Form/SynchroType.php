<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\VisiteType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\EtapeType;
use AppBundle\Form\PointVenteType;
class SynchroType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('visites', CollectionType::class, array('entry_type'=> VisiteType::class,'allow_add' => true))
        ->add('etapes', CollectionType::class, array('entry_type'=> EtapeType::class,'allow_add' => true))
        ->add('user', EntityType::class, array('class' => 'AppBundle:Client'))  
        ->add('id')
        ->add('pointVentes', CollectionType::class, array('entry_type'=> PointVenteType::class,'allow_add' => true))
           ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Synchro',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_synchro';
    }


}
