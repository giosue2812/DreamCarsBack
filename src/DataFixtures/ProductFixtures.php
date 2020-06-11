<?php


namespace App\DataFixtures;


use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Supplier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $supplier = new Supplier();
        $supplier->setNom('Bosch Belgique');
        $supplier->setStreet('Rue des archer');
        $supplier->setNumber('14A');
        $supplier->setPostalCode("74575");
        $supplier->setCity('Liege');
        $supplier->setCountry('Belgique');
        $supplier->setEmail("bosch@belgium.be");
        $supplier->setTel('02554366');

        $manager->persist($supplier);

        $category = new Category();
        $category->setName('Frein');

        $manager->persist($category);

        $subCategory = new Category();
        $subCategory->setName('Plaquette');
        $subCategory->setSubCategory($category);

        $manager->persist($subCategory);

        $product = new Product();
        $product->setProduct('Plaquette Bosch');
        $product->setDescription('Frein Bosch Bonne qualité');
        $product->setCategory($subCategory);
        $product->setAvaibility(true);
        $product->setPrice(14.15);
        $product->setSupplier($supplier);

        $manager->persist($product);

        $manager->flush();
    }
}
