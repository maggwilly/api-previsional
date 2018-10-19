<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
class CampagneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
        ->add('pays', ChoiceType::class, array(
            'label'  => 'Ville de la campagne',
            'choices'  => array(
               'cameroun' => 'Cameroun',
               'congo' => 'Congo', 
               'cote ivoire' => 'cote ivoire'),
            ))
        ->add('ville','text', array(
            'label'  => 'Ville de la campagne',
            ))
        ->add('statut', ChoiceType::class, array(
              'choices'  => array(
                 'En préparation' => 'En préparation',
                 'En cours' => 'En cours', 
                 'Terminé' => 'Terminé'),
              ))
        ->add('datedebut','datetime', array(
            'label'  => "Debut de l'actiité",
            ))
        ->add('dprospects',UrlType::class, array(
            'label'  => 'Lien vers le dernier rapports',
            ))
        ->add('drapports',UrlType::class, array(
            'label'  => 'Lien vers la liste des prospects',
            ))     
        ->add('description');  
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Campagne'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_campagne';
    }


}
