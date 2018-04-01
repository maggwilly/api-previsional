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
        $builder->add('text','textarea',array('label'=>'Enonce de la question'))
        ->add('propA','textarea',array('label'=>'Proposition A'))
        ->add('propB','textarea',array('label'=>'Proposition B'))
        ->add('propC','textarea',array('label'=>'Proposition C','required'=>false))
        ->add('propD','textarea',array('label'=>'Proposition D','required'=>false))
        ->add('rep', ChoiceType::class, array(
                                     'choices'  => array(
                                         'a' => 'Proposition de réponse A',
                                         'b' => 'Proposition de réponse B',
                                         'c' => 'Proposition de réponse C',
                                         'd' => 'Proposition de réponse D'),
                                         'label'=>'Proposition de réponse juste'))
        ->add('time',ChoiceType::class, array(
                                     'choices'  => array(
                                         '3' => '3 minutes',
                                         '5' => '5 minutes',
                                         '10' => '10 minutes',
                                         '15' => '15 minutes',
                                         '20' => '20 minutes',
                                         '30' => '30 minutes' ),
                                        'label'=>'Durée max pour la reponse'))        
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
        return 'app_bundle';
    }


}
