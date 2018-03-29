<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PartieEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre','text',array('label'=>'Titre de la partie'))
        ->add('objectif','textarea',array('label'=>'Brève description '))
        ->add('sources', 'textarea' ,array('label'=>'Description complete','attr'=>array('class'=>'cleditor')))
        ->add('containMath', 'checkbox' ,array('label'=>'Contient des formules'))
        ->add('auMoinsdeMemeQue', EntityType::class, 
            array('class' => 'AppBundle:Partie' , 
                'choice_label' => 'titre',
                'label'=>'Attribuer un contenu existant',
                'empty_data' => null,
                'placeholder' => 'Aucun contenu existant',
                'required' => false   ,              
                'group_by' => function($val, $key, $index) {
                            return $val->getMatiere()->getDisplayName();
               }));
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