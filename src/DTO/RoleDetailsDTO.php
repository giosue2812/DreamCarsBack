<?php


namespace App\DTO;


use App\Entity\Role;

class RoleDetailsDTO
{
    /**
     * @var string $role
     */
    private $role;
    /**
     * @var \DateTime $create_at
     */
    private $create_at;
    /**
     * @var \DateTime $update_at
     */
    private $update_at;

    /**
     * RoleDetailsDTO constructor.
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role->getRole();
        $this->create_at = $role->getCreateAt();
        $this->update_at = $role->getUpdateAt();
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
