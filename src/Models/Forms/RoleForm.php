<?php


namespace App\Models\Forms;


class RoleForm
{
    /**
     * @var integer $id_role
     */
    private int $id_role;

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
