<?php


namespace App\DTO;


use App\Entity\Groupe;

class GroupeDetailsDTO
{
    /**
     * @var int $id_groupe
     */
    private $id_groupe;
    /**
     * @var string $groupe
     */
    private $groupe;
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
     * GroupeDetailsDTO constructor.
     * @param Groupe $groupe
     */
    public function __construct(Groupe $groupe)
    {
        $this->id_groupe = $groupe->getId();
        $this->groupe = $groupe->getGroupe();
        $this->create_at = $groupe->getCreateAt();
        $this->update_at = $groupe->getUpdateAt();
        $this->delete_at = $groupe->getDeleteAt();
    }

    /**
     * @return string
     */
    public function getGroupe(): string
    {
        return $this->groupe;
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
