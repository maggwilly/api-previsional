<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class PartieEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
        ->add('cours')
        ->add('objectif')
        ->add('sources')
        ->add('prerequis')
        ->add('auMoinsdeMemeQue', EntityType::class, 
            array('class' => 'AppBundle:Partie' , 
              'choice_label' => 'titre',
                'label'=>'Les même questions que', 'empty_data' => null,
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