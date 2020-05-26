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
     *     type="integer",
     *     description="UserRole's UserId"
     * )
     * @var int $user
     */
    private $user;
    /**
     * @OA\Property(
     *     property="role",
     *     type="integer",
     *     description="UserRole's RoleId"
     * )
     * @var int $role
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
     * @param int $id
     * @return UserRoleDetailsDTO
     */
    public function setId(int $id): UserRoleDetailsDTO
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param int $user
     * @return UserRoleDetailsDTO
     */
    public function setUser(int $user): UserRoleDetailsDTO
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @param int $role
     * @return UserRoleDetailsDTO
     */
    public function setRole(int $role): UserRoleDetailsDTO
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartAt(): \DateTime
    {
        return $this->startAt;
    }

    /**
     * @param \DateTime $startAt
     * @return UserRoleDetailsDTO
     */
    public function setStartAt(\DateTime $startAt): UserRoleDetailsDTO
    {
        $this->startAt = $startAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     * @return UserRoleDetailsDTO
     */
    public function setEndDate(\DateTime $endDate): UserRoleDetailsDTO
    {
        $this->endDate = $endDate;
        return $this;
    }

}
