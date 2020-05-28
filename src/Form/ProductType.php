<?php

namespace App\Form;

use App\Entity\Product;
use App\Models\Forms\ProductForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product',TextType::class,[
                'required'=>true
            ])
            ->add('price', TextType::class,[
                'required'=>true
            ])
            ->add('picture',TextType::class,[
                'required'=>true
            ])
            ->add('description',TextType::class,[
                'required'=>true
            ])
            ->add('avaibility',TextType::class,[
                'required'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductForm::class,
        ]);
    }
}
