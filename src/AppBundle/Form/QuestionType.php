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
        $partie=$options['partie'];
        $builder->add('type', ChoiceType::class, array('label'=>'Type de question',
                                 'choices'  => array(
                                         'text' => 'Texte uniquement',
                                         'image_text' => 'Image et texte',
                                          'math_text' => 'Math et text',
                                          'math' => 'Math & prop Maths',
             ),
          ))
        ->add('text','textarea',array('label'=>'Enonce de la question'))
        ->add('image','textarea',array('label'=>'Image de la question','required'=>false))
        ->add('propA')
        ->add('propB')
        ->add('propC')
        ->add('propD')
        ->add('propE')
        ->add('time','integer',array('label'=>'Duree pour repondre'))
        ->add('rep', ChoiceType::class, array(
                                     'choices'  => array(
                                         'a' => 'A',
                                         'b' => 'B',
                                         'c' => 'C',
                                         'd' => 'D',
                                         'e' => 'E' ),
                                      'label'=>'Proposition juste'))
        ->add('explication','textarea',array('label'=>'Une explication de la reponse','required'=>false))
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
