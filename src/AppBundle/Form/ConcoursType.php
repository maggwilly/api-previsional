<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
class ConcoursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom')
        ->add('ecole','textarea', array('label'=>"Le nom de l'école"))
        ->add('abreviation','text', array('label'=>"Le nom abrégé de l'école"))
        ->add('descriptionEcole','textarea', array('label'=>"Une brève description de l'école"))
        ->add('descriptionConcours','textarea', array('label'=>"Une brève description du concours"))
        ->add('serie', ChoiceType::class, array(
                                  'choices'  => array(
                                          '' => 'Toute series',
                                         'science' => 'science',
                                         'Lettres' => 'Lettres',
                                         'economie' => 'economie', 
                                         'droit' => 'droit', 
                                         'technique' => 'technique'),
                                  'label'=>"La série concernée par le concours"
                                   ))
        ->add('niveau', ChoiceType::class, array(
                                  'choices'  => array(
                                          '' => 'Tous les niveaux',
                                         'CEPE' => 'CEPE',
                                         'BEPC - GCE O/L' => 'BEPC - GCE O/L',
                                         'BAC - GCE A/L' => 'BAC - GCE A/L', 
                                         'Licence & equiv' => 'Licence & equiv', 
                                         'Master & equiv' => 'Master & equiv'),
                                  'label'=>"Le niveau récquis pour le concours"
                                   ))
        ->add('dateMax', 'date', array('label'=>'Etre né après le ','years' => range(1980, 2035), 'format' => 'dd-MMMM-yyyy','widget' => 'single_text','format' => 'yyyy-MM-dd','required' => false))    
        ->add('contacts','text', array('label'=>"Des contacts séparés par des point-virgule",'required' => false))
        ->add('imageUrl', UrlType::class, array('label'=>"L'url vers une image descriptive",'required' => false));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Concours'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_concours';
    }


}
