<?php


namespace App\Models\Forms;


use App\Entity\Groupe;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Groupe Form Model",
 *     type="object",
 *     title="Groupe Form Model"
 * )
 * Class GroupeForm
 * @package App\Models\Forms
 */
class GroupeForm
{
    /**
     * @OA\Property(
     *     property="groupe",
     *     type="string",
     *     description="Groupe to update"
     * )
     * @var string $groupe
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $groupe;

    /**
     * @return string
     */
    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    /**
     * @param string $groupe
     * @return GroupeForm
     */
    public function setGroupe(string $groupe): GroupeForm
    {
        $this->groupe = $groupe;
        return $this;
    }


}
