<?php


namespace App\Models\Forms;


use App\Entity\Groupe;

class GroupeForms
{
    /**
     * @var string $groupe
     */
    private $groupe;

    /**
     * @return string
     */
    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    /**
     * @param string $groupe
     * @return GroupeForms
     */
    public function setGroupe(string $groupe): GroupeForms
    {
        $this->groupe = $groupe;
        return $this;
    }


}
