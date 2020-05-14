<?php


namespace App\Models\Forms;


use Symfony\Component\Validator\Constraints as Assert;

class RoleFormAdd
{
    /**
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
