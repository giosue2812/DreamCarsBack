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
    /**
     * @var boolean $active
     * @OA\Property(
     *     property="active",
     *     type="boolean",
     *     description="Active Category"
     * )
     */
    private $active;

    public function __construct(Category $category)
    {
        $this->id = $category->getId();
        $this->name = $category->getName();
        $this->active = $category->getIsActive();
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
