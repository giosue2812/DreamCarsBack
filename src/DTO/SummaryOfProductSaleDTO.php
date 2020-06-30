<?php


namespace App\DTO;


use App\Entity\BeSales;
use OpenApi\Annotations as OA;

/**
 * Class SummaryOfProductSaleDTO
 * @package App\DTO
 * @OA\Schema(
 *     description="Summary of product sale model",
 *     type="object",
 *     title="Summary of product"
 * )
 */
class SummaryOfProductSaleDTO
{
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
     *     property="quantity",
     *     type="integer",
     *     description="Product qty ordered"
     * )
     * @var integer $quantity
     */
    private $quantity;
    /**
     * @OA\Property(
     *     property="Unit price",
     *     type="integer",
     *     description="Product unit price"
     * )
     * @var float $unitPrice
     */
    private $unitPrice;
    /**
     * @OA\Property(
     *     property="totalPrice",
     *     type="float",
     *     description="Total Price of product ordered"
     * )
     * @var float $totalPrice
     */
    private $totalPrice;
    /**
     * @OA\Property(
     *     property="date",
     *     type="string",
     *     description="Date of order"
     * )
     * @var \DateTime $date
     */
    private $date;
    /**
     * @OA\Property(
     *     property="typePayement",
     *     type="integer",
     *     description="Type of payement of order"
     * )
     * @var string|null $typePayment
     */
    private $typePayment;

    /**
     * SummaryOfProductSaleDTO constructor.
     * @param BeSales $beSales
     */
    public function __construct(BeSales $beSales)
    {
        $this->product = $beSales->getProduct()->getProduct();
        $this->quantity = $beSales->getQuantity();
        $this->unitPrice = $beSales->getProduct()->getPrice();
        $this->date = $beSales->getProductSale()->getDate();
        $this->typePayment = $beSales->getProductSale()->getPayement()->getNamePayement();
        $this->totalPrice = $this->getTotalPrice();
    }

    /**
     * @return string
     */
    public function getProduct(): string
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->getUnitPrice() * $this->getQuantity();
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getTypePayment(): ?string
    {
        return $this->typePayment;
    }
}
