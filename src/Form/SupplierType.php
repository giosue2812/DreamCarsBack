<?php

namespace App\Form;

use App\Entity\Supplier;
use App\Models\Forms\SupplierForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupplierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('street')
            ->add('number')
            ->add('postalCode')
            ->add('tel')
            ->add('email')
            ->add('city')
            ->add('country')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SupplierForm::class,
        ]);
    }
}
