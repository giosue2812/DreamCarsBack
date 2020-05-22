<?php


namespace App\DTO;


use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserRole;

use OpenApi\Annotations as OA;

/**
 * Class UserRoleDetailsDTO
 * @package App\DTO
 * @OA\Schema(
 *     description="UserRole model",
 *     type="object",
 *     title="UserRole Model"
 * )
 */
class UserRoleDetailsDTO
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     description="Id of user role"
     * )
     * @var int $id
     */
    private $id;
    /**
     * @OA\Property(
     *     property="user",
     *     ref="#/components/schemas/UserDetailsDTO",
     *     type="object",
     *     description="UserRole's User"
     * )
     * @var User $user
     */
    private $user;
    /**
     * @OA\Property(
     *     property="role",
     *     ref="#/components/schemas/RoleDetailsDTO",
     *     type="object",
     *     description="UserRole's Role"
     * )
     * @var Role $role
     */
    private $role;
    /**
     * @OA\Property(
     *     property="startAt",
     *     type="string",
     *     format="date",
     *     description="Start date of the user role"
     * )
     * @var \DateTime $startAt
     */
    private $startAt;
    /**
     * @OA\Property(
     *     property="endDate",
     *     type="string",
     *     format="date",
     *     description="End date of the user role"
     * )
     * @var \DateTime $endDate
     */
    private $endDate;

    public function __construct(UserRole $userRole)
    {
        $this->id = $userRole->getId();
        $this->role = $userRole->getRoles()->getId();
        $this->user = $userRole->getUsers()->getId();
        $this->startAt = $userRole->getStartDate();
        $this->endDate = $userRole->getEndDate();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @return \DateTime
     */
    public function getStartAt(): \DateTime
    {
        return $this->startAt;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }


}
