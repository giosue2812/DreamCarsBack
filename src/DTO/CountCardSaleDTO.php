<?php


namespace App\DTO;

use OpenApi\Annotations as OA;
/**
 * Class CountCardSaleDTO
 * @package App\DTO
 * @OA\Schema(
 *     description="Count card sale",
 *     type="object",
 *     title="Card Count model"
 * )
 */
class CountCardSaleDTO
{
    /**
     * @OA\Property(
     *     property="count",
     *     type="integer",
     *     description="Count card's sale"
     * )
     * @var $count int
     */
    private $count;

    /**
     * CountCardSaleDTO constructor.
     * @param $count
     */
    public function __construct($count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

}
