<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class QuestionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', ChoiceType::class, array(
                                 'choices'  => array(
                                         'text' => 'Texte uniquement',
                                         'image_text' => 'Image et texte',
                                          'math_text' => 'Math et text',
                                          'math' => 'Math & prop Maths',
             ),
          ))
        ->add('text')  
        ->add('math')
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
            'data_class' => 'AppBundle\Entity\Question'
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
