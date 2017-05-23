<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class QuestionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $partie=$options['partie'];
        $builder->add('type', ChoiceType::class, array(
                                 'choices'  => array(
                                         'text' => 'Texte uniquement',
                                         'image_text' => 'Image et texte',
                                          'math_text' => 'Math et text',
                                          'math' => 'Math & prop Maths',
             ),
          ))
        ->add('objectif', EntityType::class, array(
    'class' => 'AppBundle:Objectif','choice_label' => 'titre',
    'choices' => $partie->getObjectifs(),
       ))
        ->add('text')  
        ->add('image')
        ->add('propA')
        ->add('propB')
        ->add('propC')
        ->add('propD')
        ->add('propE')
        ->add('note')
        ->add('rep', ChoiceType::class, array(
                                 'choices'  => array(
                                         'a' => 'Proposition A',
                                         'b' => 'Proposition B',
                                          'c' => 'Proposition C',
                                          'd' => 'Proposition D',
                                        'e' => 'Proposition E',
            ),
          ))
        ->add('time')
         ->add('hint')
         ->add('historique')
        ->add('explication')
   ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question','partie'=>null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_question';
    }


}
