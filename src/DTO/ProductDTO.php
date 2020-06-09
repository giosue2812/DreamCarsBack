<?php


namespace App\DTO;


use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Supplier;
use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;
/**
 * Class ProductDTO
 * @package App\DTO
 * @OA\Schema(
 *     description="Product Model",
 *     type="object",
 *     title="Product Model"
 * )
 */
class ProductDTO
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     description="Product id"
     * )
     * @var integer $id
     */
    private $id;
    /**
     * @OA\Property(
     *     property="product",
     *     type="string",
     *     description="Product name"
     * )
     * @var string $product
     */
    private $product;
    /**
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Product's description"
     * )
     * @var string $description
     */
    private $description;
    /**
     * @OA\Property(
     *     property="price",
     *     type="integer",
     *     description="Price of product"
     * )
     * @var float $price
     */
    private $price;
    /**
     * @OA\Property(
     *     property="category",
     *     type="string",
     *     description="Product Category"
     * )
     * @var Category $category
     */
    private $category;
    /**
     * @OA\Property(
     *     property="picture",
     *     type="string",
     *     description="Picture of product"
     * )
     * @var string $picture
     */
    private $picture;
    /**
     * @var Supplier $supplier
     * @OA\Property(
     *     property="supplier",
     *     type="string",
     *     description="Supplier of product"
     * )
     */
    private $supplier;
    /**
     * @OA\Property(
     *     property="avaibility",
     *     type="boolean",
     *     description="Stock available for the product"
     * )
     * @var boolean $avaibility
     */
    private $avaibility;

    /**
     * @var \DateTime $deleteAt
     * @OA\Property(
     *     property="deleteAt",
     *     type="string",
     *     description="Delete date"
     * )
     * @Serializer\SerializedName("deleteAt")
     */
    private $deleteAt;

    public function __construct(Product $product)
    {
        $this->id = $product->getId();
        $this->product = $product->getProduct();
        $this->description = $product->getDescription();
        $this->price = $product->getPrice();
        $this->picture = $product->getPicture();
        $this->supplier = $product->getSupplier();
        $this->avaibility = $product->getAvaibility();
        $this->deleteAt = $product->getDeleteAt();
        $this->category = $product->getCategory()->getName();
        $this->supplier = $product->getSupplier()->getName();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProduct(): ?string
    {
        return $this->product;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @return Supplier
     */
    public function getSupplier(): Supplier
    {
        return $this->supplier;
    }

    /**
     * @return bool
     */
    public function isAvaibility(): ?bool
    {
        return $this->avaibility;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return \DateTime
     */
    public function getDeleteAt(): \DateTime
    {
        return $this->deleteAt;
    }



}
