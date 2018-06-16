<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
class PartieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre','text',array('label'=>'Titre de la partie'))
                ->add('objectif', 'textarea',array('label'=>'Brève description'))
        ->add('sources', 'textarea' ,array('label'=>'Description complete','attr'=>array('class'=>'ckeditor')))
        ->add('cours', UrlType::class,array('label'=>'lien vers le cours','required'=>false))
        ->add('containMath', 'checkbox' ,array('label'=>'Contient des formules mathematiques ?','required'=>false))
        ->add('index')
        ->add('type', ChoiceType::class, array(
                                 'choices'  => array(
                                  'TD' => 'Travaux dirigés', 'EP' => 'Ancienne épreuve'),
                                   ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Partie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_partie';
    }


}
