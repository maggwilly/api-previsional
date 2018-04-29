<?php

namespace Pwm\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class RessourceSuperType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
     
        ->add('nom','text', array(
           'label' => 'Nom du document',
         ))
        ->add('description','textarea', array(
           'label' => 'Une description commerciale du document',
         ))
        
        ->add('detail1','text', array(
           'label' => 'Autre détail 1','required' =>false
         ))
        ->add('detail2','text', array(
           'label' => 'Autre détail 2','required' =>false
         ))
        ->add('detail3','text', array(
           'label' => 'Autre détail 3','required' =>false
         ))
        ->add('detail4','text', array(
           'label' => 'Autre détail 4','required' =>false
         ))
        ->add('style','text', array(
           'label' => 'Type de document (pdf/image/doc/excel etc.)',
         ))
        ->add('size','text', array(
           'label' => 'Nombre de pages',
         )) 
        ->add('price','integer', array(
          'label' => 'Prix de la ressource',
         ))       
        ->add('url', UrlType::class, array(
          'label' => 'Lien de télechargement',
         ))
        ->add('imageUrl', UrlType::class, array(
       'label' => 'Lien vers la photo',
))
  ->add('sessions', EntityType::class,
                       array('class' => 'AppBundle:Session', 
                           'choice_label' => 'abreviation', 
                           'placeholder' => 'Toute les sessions',
                            'empty_data'  => null,
                            'required' => false,
                            'label'=>'Selectionnez les concours',      
                            'multiple'=>true,
                            'expanded'=>false,                  
                            'attr'=>array('data-rel'=>'chosen')))
        ;
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
