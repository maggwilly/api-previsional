<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CredentialsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login');
        $builder->add('password');
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Credentials',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_credentials';
    }
}