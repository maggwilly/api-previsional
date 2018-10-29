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
            'label'  => 'Pays de la campagne',
            'choices'  => array(
               'cameroun' => 'Cameroun',
               'congo' => 'Congo', 
               'cote ivoire' => 'cote ivoire'),
            ))
        ->add('ville','text', array(
            'label'  => 'Villes de la campagne',
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
            'label'  => 'Lien vers la liste des prospects',
            'required'=>false
            ))
        ->add('drapports',UrlType::class, array(
<<<<<<< HEAD
            'label'  => ' Lien vers le dernier rapports',
=======
            'label'  => 'Lien vers le dernier rapports',
>>>>>>> 02a74b2f0773fd33a770d848ab9a1defaa48f9d8
            'required'=>false
            )) 
            ->add('folder','text', array(
                'label'  => 'Nom du dossier',
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
