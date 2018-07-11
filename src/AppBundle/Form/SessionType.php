<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Repository\PartieRepository;
class SessionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
       
        ->add('nomConcours','text', array('label'=>'Nom cours du concours','required' => true))
        ->add('abreviation')
        ->add('serie', ChoiceType::class, array(
                                  'choices' => array(
                                           'science' => 'science',
                                           'Lettres' => 'Lettres',
                                           'economie' => 'economie',
                                           'droit' => 'droit', 
                                           'technique' => 'technique'),
                                  'multiple'=>true,
                                  'expanded'=>false,
                                  'attr'=>array('data-rel'=>'chosen'),
                                  'required' => false
                                   ))
        ->add('niveau', ChoiceType::class, array(
                                  'choices'  => array(
                                         '' => 'Tous les niveaux',
                                         'CEPE' => 'CEPE',
                                         'BEPC - GCE O/L' => 'BEPC - GCE O/L',
                                         'BAC - GCE A/L' => 'BAC - GCE A/L', 
                                         'Licence & equiv' => 'Licence & equiv', 
                                         'Master & equiv' => 'Master & equiv')
                                  ,'required' => false
                                   ))
        ->add('nom','text', array('label'=>'Liste des séries consernées','required' => true))
        ->add('dateMax', 'date', array('widget' => 'single_text','format' => 'yyyy-MM-dd','years' => range(1980, 2035),'label'=>'Etre né après','required' => false) )       
        ->add('nombrePlace', 'integer', array('label'=>'Places disponibles','required' => false))
        ->add('nombreInscrit', 'integer', array('label'=>'Déjà inscrit au concours','required' => false))
        ->add('dateLancement', 'date', array('widget' => 'single_text','format' => 'yyyy-MM-dd','required' => false) )
        ->add('dateConcours', 'date', array('widget' => 'single_text','format' => 'yyyy-MM-dd','required' => false))
        ->add('dateDossier', 'date', array('widget' => 'single_text','format' => 'yyyy-MM-dd','required' => false))
        ->add('type', ChoiceType::class, array(
                                 'choices'  => array(
                                  'écrit' => 'Epreuves écrites', 'direct' => 'Etude de dossier', 'sport' => 'Epreuves sportives', 
                                  'Olympiades' => 'Olympiades'),
                                   ))
        ->add('price', EntityType::class,
             array('class' => 'AdminBundle:Price', 
                   'choice_label' => 'getNom', 
                    'placeholder' => 'Choisir un tarifaire',
                    'empty_data'  => null,
                   'empty_data' => null,
                   'label'=>'Tarifaire','required' => false)
             )   
         ->add('shouldAlert', 'checkbox' ,array('label'=>'Envoyer une alerte','required' => false))
          ->add('archived', 'checkbox' ,array('label'=>'Archivé','required' => false))         
         ->add('preparation', EntityType::class,
             array('class' => 'AppBundle:Programme', 
                   'choice_label' => 'getNom', 
                   'placeholder' => 'Aucun Programme',
                   'empty_data'  => null,
                    'required' => false,
                   'label'=>'Programme de prépa',
                   'attr'=>array('data-rel'=>'chosen'))
             )
     /* ->add('owner', EntityType::class,
             array('class' => 'AdminBundle:Info', 
                   'choice_label' => 'getDisplayName', 
                   'placeholder' => 'Aucun administrateur',
                   'label' => 'Administrateur des discussions',
                   'empty_data'  => null,
                    'required' => false)
             ) */;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Session'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_session';
    }


}
