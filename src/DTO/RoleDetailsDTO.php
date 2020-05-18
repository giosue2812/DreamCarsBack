<?php


namespace App\DTO;


use App\Entity\Role;

class RoleDetailsDTO
{
    /**
     * @var integer $id_role;
     */
    private $id_role;
    /**
     * @var string $role
     */
    private ?string $role;
    /**
     * @var \DateTime $create_at
     */
    private $create_at;
    /**
     * @var \DateTime $update_at
     */
    private $update_at;

    /**
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
