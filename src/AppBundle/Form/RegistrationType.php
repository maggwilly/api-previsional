<?php
  
    namespace AppBundle\Form;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;

    class RegistrationType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder->add('nom')->add('phone')
            ->add('ville', 'choice', array('required' => true,'choices'=>array('DOUALA'=>'DOUALA','YAOUNDE'=>'YAOUNDE',)))
            ->add('type', 'choice', array('required' => true,'choices'=>array('SAISIE'=>'SAISIE','COMM'=>'COMM','ADMIN'=>'ADMIN')));
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