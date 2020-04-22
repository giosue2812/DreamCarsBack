<?php

namespace App\Form;

use App\Models\Forms\UserFormUpdate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserUpdateType extends AbstractType
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
            ->add('city',TextType::class,[
                'required' => true
            ])
            ->add('country',TextType::class,[
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> UserFormUpdate::class
        ]);
    }
}
