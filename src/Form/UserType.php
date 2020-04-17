<?php

namespace App\Form;

use App\Entity\User;
use App\Models\Forms\UserForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class,[
                'required' => true
            ])
            ->add('lastName',TextType::class,[
                'required' => true
            ])
            ->add('email',EmailType::class,[
                'required' => true
            ])
            ->add('phone',TextType::class,[
                'required' => false
            ])
            ->add('street',TextType::class,[
                'required' => true
            ])
            ->add('number',TextType::class,[
                'required' => true
            ])
            ->add('postalCode',TextType::class,[
                'required' => true
            ])
            ->add('country',TextType::class,[
                'required' => true
            ])
            ->add('password',PasswordType::class,[
                'required' => true
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            /**
             * Use a model form
             */
            'data_class' => UserForm::class,
        ]);
    }
}
