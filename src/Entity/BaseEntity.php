<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class BaseEntity
 * @package App\Entity
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
class BaseEntity
{
    /**
     * @ORM\Column(type="date")
     */
    private $createAt;
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updateAt;
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $deleteAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @return mixed
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @param mixed $createAt
     * @return BaseEntity
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @param mixed $updateAt
     * @return BaseEntity
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeleteAt()
    {
        return $this->deleteAt;
    }

    /**
     * @param mixed $deleteAt
     * @return BaseEntity
     */
    public function setDeleteAt($deleteAt)
    {
        $this->deleteAt = $deleteAt;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     * @return BaseEntity
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function createEvent()
    {
        $this->createAt = new \DateTime();
        $this->isActive = true;
    }


}
