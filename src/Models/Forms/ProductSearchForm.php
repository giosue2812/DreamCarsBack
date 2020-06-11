<?php


namespace App\Models\Forms;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ProductSearchForm
 * @package App\Models\Forms
 * @OA\Schema(
 *     description="Form to search",
 *     type="object",
 *     title="Form Search Model"
 * )
 */

class ProductSearchForm
{
    /**
     * @var string $keyWord
     * @OA\Property(
     *     property="keyWord",
     *     type="string",
     *     description="keyWord to found a product"
     * )
     */
    private $keyWord;

    /**
     * @return string
     */
    public function getKeyWord(): ?string
    {
        return $this->keyWord;
    }

    /**
     * @param string $keyWord
     * @return ProductSearchForm
     */
    public function setKeyWord(string $keyWord): ProductSearchForm
    {
        $this->keyWord = $keyWord;
        return $this;
    }


}
