<?php


namespace App\DTO;


use App\Entity\BeSales;
use OpenApi\Annotations as OA;
/**
 * Class ProductSaleDTO
 * @package App\DTO
 * @OA\Schema(
 *     description="Product Sale Model",
 *     type="object",
 *     title="Product sale Model"
 * )
 */
class ProductSaleDTO
{
    /**
     * @OA\Property(
     *     property="user",
     *     type="integer",
     *     description="User id"
     * )
     * @var $user string|null
     */
    private $user;
    /**
     * @var $date \DateTimeInterface|null
     * @OA\Property(
     *     property="date",
     *     type="string",
     *     description="Date Time of sold product"
     * )
     */
    private $date;
    /**
     * @var $product string|null
     * @OA\Property(
     *     property="product",
     *     type="string",
     *     description="Product sold"
     *
     * )
     */
    private $product;
    /**
     * @var $quantity string|null
     * @OA\Property(
     *     property="quantity",
     *     type="integer",
     *     description="Quantity sold"
     * )
     */
    private $quantity;
    /**
     * @var $picture string|null
     * @OA\Property(
     *     property="picture",
     *     type="string",
     *     description="Picture of sold product"
     * )
     */
    private $picture;
    /**
     * @var $price string|null
     * @OA\Property(
     *     property="price",
     *     type="integer",
     *     description="Price of product"
     * )
     */
    private $price;

    /**
     * ProductSaleDTO constructor.
     * @param BeSales $beSales
     */
    public function __construct(BeSales $beSales)
    {
        $this->user = $beSales->getProductSale()->getUser()->getEmail();
        $this->date = $beSales->getProductSale()->getDate();
        $this->product = $beSales->getProduct()->getProduct();
        $this->quantity = $beSales->getQuantity();
        $this->picture = $beSales->getProduct()->getPicture();
        $this->price = $beSales->getProduct()->getPrice();
    }

    /**
     * @return string|null
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getProduct(): ?string
    {
        return $this->product;
    }

    /**
     * @return string|null
     */
    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    /**
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }


}
