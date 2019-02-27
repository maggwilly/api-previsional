<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('value')
        ->add('user', EntityType::class, array('class' => 'AppBundle:User'));
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\AuthToken',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_authtoken';
    }
}