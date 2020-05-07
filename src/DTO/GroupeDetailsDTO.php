<?php


namespace App\DTO;


use App\Entity\Groupe;

class GroupeDetailsDTO
{
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
     * GroupeDetailsDTO constructor.
     * @param Groupe $groupe
     */
    public function __construct(Groupe $groupe)
    {
        $this->groupe = $groupe->getGroupe();
        $this->create_at = $groupe->getCreateAt();
        $this->update_at = $groupe->getUpdateAt();
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
