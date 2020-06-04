<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Supplier;
use App\Models\Forms\CategoryForm;
use App\Models\Forms\ProductForm;
use App\Models\Forms\SupplierAddForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add('price', NumberType::class,[
                'required'=>true
            ])
            ->add('picture',TextType::class,[
                'required'=>false
            ])
            ->add('description',TextType::class,[
                'required'=>false
            ])
            ->add('avaibility',CheckboxType::class,[
                'required'=>true
            ])
            ->add('category',CategoryType::class,[
                'data_class'=>CategoryForm::class
            ])
            ->add('supplier',SupplierAddType::class,[
                'data_class'=>SupplierAddForm::class
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
