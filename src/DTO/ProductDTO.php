<?php


namespace App\DTO;


use App\Entity\Category;
use App\Entity\Product;
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
     *     type="float",
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
     * @OA\Property(
     *     property="avaibility",
     *     type="boolean",
     *     description="Stock available for the product"
     * )
     * @var boolean $avaibility
     */
    private $avaibility;

    public function __construct(Product $product)
    {
        $this->id = $product->getId();
        $this->product = $product->getProduct();
        $this->description = $product->getDescription();
        $this->price = $product->getPrice();
        $this->picture = $product->getPicture();
        $this->avaibility = $product->getAvaibility();
        $this->category = $product->getCategory()->getName();
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
     * @return bool
     */
    public function isAvaibility(): ?bool
    {
        return $this->avaibility;
    }


}
