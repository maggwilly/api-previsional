<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\TextareaType;
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
        ->add('text',TextareaType::class,array('label'=>'Enonce de la question'))
        ->add('image',TextareaType::class,array('label'=>'Image de la question'))
        ->add('propA')
        ->add('propB')
        ->add('propC')
        ->add('propD')
        ->add('propE')
        ->add('time',IntegerType::class,array('label'=>'Duree pour repondre'))
        ->add('rep', ChoiceType::class, array(
                                     'choices'  => array(
                                         'a' => 'A',
                                         'b' => 'B',
                                         'c' => 'C',
                                         'd' => 'D',
                                         'e' => 'E' ),
                                      'label'=>'Proposition juste'))
        ->add('explication',TextareaType::class,array('label'=>'Une explication de la reponse'))
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
