<?php


namespace App\Models\Forms;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RoleForm
 * @package App\Models\Forms
 * @OA\Schema(
 *     description="Role Form",
 *     type="object",
 *     title="Role form"
 * )
 */
class RoleForm
{
    /**
     * @OA\Property(
     *     property="id_role",
     *     type="integer",
     *     description="Id role for the role selected"
     * )
     * @var integer $id_role
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $id_role;

    /**
     * @return int
     */
    public function getIdRole(): ?int
    {
        return $this->id_role;
    }

    /**
     * @param int $id_role
     * @return RoleForm
     */
    public function setIdRole(int $id_role): RoleForm
    {
        $this->id_role = $id_role;
        return $this;
    }

}
