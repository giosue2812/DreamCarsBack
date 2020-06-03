<?php


namespace App\Models\Forms;


use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * Class SupplierAddForm
 * @package App\Models\Forms
 * @OA\Schema(
 *     description="Supplier form model to add for product",
 *     type="object",
 *     title="Supplier form model"
 * )
 */
class SupplierAddForm
{
    /**
     * @var string $name
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @OA\Property(
     *      property="name",
     *     type="string",
     *     description="Nom of supplier"
     * )
     */
    private $name;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SupplierAddForm
     */
    public function setName(string $name): SupplierAddForm
    {
        $this->name = $name;
        return $this;
    }


}
