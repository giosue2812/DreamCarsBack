<?php


namespace App\Models\Forms;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CategoryForm
 * @package App\Models\Forms
 * @OA\Schema(
 *     description="Category form Model",
 *     type="object",
 *     title="Category form model"
 * )
 */

class CategoryForm
{
    /**
     * @Assert\Type("string")
     * @var string $name
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="name of category to update"
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
     * @return CategoryForm
     */
    public function setName(string $name): CategoryForm
    {
        $this->name = $name;
        return $this;
    }

}
