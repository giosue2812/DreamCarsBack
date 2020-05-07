<?php


namespace App\Models\Forms;


use App\Entity\Groupe;

class GroupeForm
{
    /**
     * @var string $groupe
     */
    private string $groupe;

    /**
     * @return string
     */
    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    /**
     * @param string $groupe
     * @return GroupeForm
     */
    public function setGroupe(string $groupe): GroupeForm
    {
        $this->groupe = $groupe;
        return $this;
    }


}
