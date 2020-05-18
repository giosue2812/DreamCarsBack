<?php


namespace App\DTO;


use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserRole;

class UserRoleDetailsDTO
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var User $user
     */
    private $user;
    /**
     * @var Role $role
     */
    private $role;
    /**
     * @var \DateTime $startAt
     */
    private $startAt;
    /**
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
