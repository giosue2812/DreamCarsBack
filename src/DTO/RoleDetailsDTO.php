<?php


namespace App\DTO;


use App\Entity\Role;
use OpenApi\Annotations as OA;

/**
 * Class RoleDetailsDTO
 * @package App\DTO
 * @OA\Schema(
 *     description="Role model",
 *     type="object",
 *     title="Role model"
 * )
 */

class RoleDetailsDTO
{
    /**
     * @OA\Property(
     *     property="id_role",
     *     type="integer",
     *     description="Unique indetification",
     * )
     * @var integer $id_role;
     */
    private $id_role;
    /**
     * @OA\Property(
     *     property="role",
     *     type="string",*
     *     description="Role name"
     * )
     * @var string $role
     */
    private ?string $role;
    /**
     * @OA\Property(
     *     property="create_at",
     *     type="string",
     *     format="date",
     *     description="Creation Date for a new role"
     * )
     * @var \DateTime $create_at
     */
    private $create_at;
    /**
     * @OA\Property(
     *     property="update_at",
     *     type="string",
     *     format="date",
     *     description="Update date for a new role"
     * )
     * @var \DateTime $update_at
     */
    private $update_at;

    /**
     * @OA\Property(
     *     property="delete_at",
     *     type="string",
     *     format="date",
     *     description="Delete date for a new role"
     * )
     * @var \DateTime $delete_at
     */
    private $delete_at;

    /**
     * RoleDetailsDTO constructor.
     * @param Role $role
     */
    public function __construct(Role $role)
    {
            $this->id_role = $role->getId();
            $this->role = $role->getRole();
            $this->create_at = $role->getCreateAt();
            $this->update_at = $role->getUpdateAt();
            $this->delete_at = $role->getDeleteAt();
    }

    /**
     * @return int
     */
    public function getIdRole(): int
    {
        return $this->id_role;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return \DateTime
     */
    public function getCreateAt(): \DateTime
    {
        return $this->create_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateAt(): \DateTime
    {
        return $this->update_at;
    }

}
