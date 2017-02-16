<?php
  
    namespace AppBundle\Form;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;

    class RegistrationType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder->add('nom')->add('ville')->add('id');
        }
  //personnalis2
        public function getParent()
        {
            return 'fos_user_registration';
        }

        public function getName()
        {
            return 'app_user_registration';
        }
    }