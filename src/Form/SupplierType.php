<?php

namespace App\Form;

use App\Entity\Supplier;
use App\Models\Forms\SupplierForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupplierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'required'=>false
            ])
            ->add('street',TextType::class,[
                'required'=>false
            ])
            ->add('number',TextType::class,[
                'required'=>false
            ])
            ->add('postalCode',TextType::class,[
                'required'=>false
            ])
            ->add('tel',TextType::class,[
                'required'=>false
            ])
            ->add('email',EmailType::class,[
                'required'=>false
            ])
            ->add('city',TextType::class,[
                'required'=>false
            ])
            ->add('country',TextType::class,[
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SupplierForm::class,
        ]);
    }
}
