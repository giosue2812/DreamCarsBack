<?php


namespace App\DTO;


use App\Entity\Category;
use OpenApi\Annotations as OA;

/**
 * Class CategoriesChoiceDTO
 * @package App\DTO
 * @OA\Schema(
 *     description="Category model",
 *     type="object",
 *     title="Category model"
 * )
 */
class CategoriesChoiceDTO
{
    /**
     * @var integer $id
     * @OA\Property(
     *     property="id",
     *     type="string",
     *     description="Category Id"
     * )
     */
    private $id;
    /**
     * @var string $name
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Category Name"
     * )
     */
    private $name;

    public function __construct(Category $category)
    {
        $this->id = $category->getId();
        $this->name = $category->getName();
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


}
