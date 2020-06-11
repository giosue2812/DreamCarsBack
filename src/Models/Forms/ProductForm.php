<?php


namespace App\Models\Forms;


use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * Class ProductForm
 * @package App\Models\Forms
 * @OA\Schema(
 *     description="Product Form Model",
 *     type="object",
 *     title="Product Form Model"
 * )
 */
class ProductForm
{
    /**
     * @var string $product
     * @Assert\NotNull()
     * @OA\Property(
     *     property="product",
     *     type="string",
     *     description="Product name"
     * )
     */
    private $product;
    /**
     * @var int $price
     * @Assert\NotNull()
     * @OA\Property(
     *     property="price",
     *     type="integer",
     *     description="Price of product"
     * )
     */
    private $price;
    /**
     * @var string $description
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Description of product"
     * )
     */
    private $description;
    /**
     * @var boolean $avaibility
     * @Assert\NotNull()
     * @OA\Property(
     *     property="avaibility",
     *     type="boolean",
     *     description="Boolean of product"
     * )
     */
    private $avaibility;
    /**
     * @var CategoryForm $category
     * @OA\Property(
     *     property="category",
     *     type="object",
     *     description="Category of user",
     *     @OA\Schema(
     *          ref="#/components/schemas/CategoryForm"
     *     )
     * )
     */
    private $category;
    /**
     * @var SupplierAddForm $supplier
     * @OA\Property(
     *     property="supplier",
     *     type="object",
     *     description="Supplier of product",
     *     @OA\Schema(
     *          ref="#/components/schemas/SupplierAddForm"
     *     )
     * )
     */
    private $supplier;
    /**
     * @return string
     */
    public function getProduct(): ?string
    {
        return $this->product;
    }

    /**
     * @param string $product
     * @return ProductForm
     */
    public function setProduct(string $product): ProductForm
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return ProductForm
     */
    public function setPrice(int $price): ProductForm
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return ProductForm
     */
    public function setDescription(string $description): ProductForm
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAvaibility(): ?bool
    {
        return $this->avaibility;
    }

    /**
     * @param bool $avaibility
     * @return ProductForm
     */
    public function setAvaibility(bool $avaibility): ProductForm
    {
        $this->avaibility = $avaibility;
        return $this;
    }

    /**
     * @return CategoryForm
     */
    public function getCategory(): ?CategoryForm
    {
        return $this->category;
    }

    /**
     * @param CategoryForm $category
     * @return ProductForm
     */
    public function setCategory(CategoryForm $category): ProductForm
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return SupplierAddForm
     */
    public function getSupplier(): ?SupplierAddForm
    {
        return $this->supplier;
    }

    /**
     * @param SupplierAddForm $supplier
     * @return ProductForm
     */
    public function setSupplier(SupplierAddForm $supplier): ProductForm
    {
        $this->supplier = $supplier;
        return $this;
    }


}
