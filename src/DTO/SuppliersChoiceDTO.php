<?php


namespace App\DTO;


use App\Entity\Supplier;
use OpenApi\Annotations as OA;

/**
 * Class SuppliersChoiceDTO
 * @package App\DTO
 * @OA\Schema(
 *      description="Supplier Choice Model",
 *      type="object",
 *      title="Supplier Choice Model"
 * )
 */
class SuppliersChoiceDTO
{
    /**
     * @var integer $id
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     description="Product id"
     * )
     */
    private $id;
    /**
     * @var string $name
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Product Name"
     * )
     */
    private $name;

    /**
     * @var boolean $active
     * @OA\Property(
     *     property="active",
     *     type="boolean",
     *     description="Supplier is active"
     * )
     */
    private $active;

    public function __construct(Supplier $supplier)
    {
        $this->id = $supplier->getId();
        $this->name = $supplier->getName();
        $this->active = $supplier->getIsActive();
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

}
