<?php


namespace App\DTO;


use App\Entity\PayementType;
use OpenApi\Annotations as OA;

/**
 * Class PayementDTO
 * @package App\DTO
 * @OA\Schema(
 *     description="Payement model",
 *     type="object",
 *     title="Payement Model"
 * )
 */
class PayementDTO
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     description="Id of payement"
     * )
     * @var integer $id
     */
    private $id;
    /**
     * @OA\Property(
     *     property="name_payement",
     *     type="string",
     *     description="name of payement"
     * )
     * @var string $name_payement
     */
    private $name_payement;

    /**
     * PayementDTO constructor.
     * @param PayementType $payementType
     */
    public function __construct(PayementType $payementType)
    {
        $this->id = $payementType->getId();
        $this->name_payement = $payementType->getNamePayement();
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
    public function getNamePayement(): string
    {
        return $this->name_payement;
    }

}
