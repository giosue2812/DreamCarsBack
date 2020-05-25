<?php


namespace App\Models\Forms;


use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Role Form add Model",
 *     type="object",
 *     title="Role Form add Model"
 * )
 * Class RoleFormAdd
 * @package App\Models\Forms
 */
class RoleFormAdd
{
    /**
     * @OA\Property(
     *     property="groupe",
     *     type="string",
     *     description="Role to update"
     * )
     * @var string $role
     * @Assert\NotBlank()
     */
    private $role;

    /**
     * @return string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return RoleFormAdd
     */
    public function setRole(string $role): RoleFormAdd
    {
        $this->role = $role;
        return $this;
    }

}
