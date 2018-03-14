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
        ->add('objectif', TextareaType::class,array('label'=>'Brève description '))
        ->add('sources', TextareaType::class ,array('label'=>'Description complete'))
        ->add('auMoinsdeMemeQue', EntityType::class, 
            array('class' => 'AppBundle:Partie' , 
              'choice_label' => 'titre',
                'label'=>'Selectionnez un contenu', 'empty_data' => null,
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