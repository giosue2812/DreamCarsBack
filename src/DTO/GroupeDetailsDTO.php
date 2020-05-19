<?php


namespace App\DTO;


use App\Entity\Groupe;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Groupe model",
 *     type="object",
 *     title="Groupe model"
 * )
 * Class GroupeDetailsDTO
 * @package App\DTO
 */

class GroupeDetailsDTO
{
    /**
     * @OA\Property(
     *     property="id_groupe",
     *     type="integer",
     *     description="Unique identification",
     * )
     * @var int $id_groupe
     */
    private $id_groupe;
    /**
     * @OA\Property(
     *     property="groupe",
     *     type="string",
     *     description="Groupe name"
     * )
     * @var string $groupe
     */
    private $groupe;
    /**
     * @OA\Property(
     *     property="create_at",
     *     type="string",
     *     format="date",
     *     description="Creation Date for a new Groupe"
     * )
     * @var \DateTime $create_at
     */
    private $create_at;
    /**
     * @OA\Property(
     *     property="update_at",
     *     type="string",
     *     format="date",
     *     description="Update Date for a modification of an existing groupe"
     * )
     * @var \DateTime $update_at
     */
    private $update_at;
    /**
     * @OA\Property(
     *     property="delete_at",
     *     type="string",
     *     format="date",
     *     description="Delete date for removing groupe"
     * )
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
