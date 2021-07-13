<?php


namespace App\Utilities;


use Doctrine\ORM\Mapping as ORM;

trait TimeStampTrait2
{
    /**
     * @var
     * @ORM\Column (dateTime)
     */
    private $createdAt;

    /**
     * @var
     * @ORM\Column (dateTime)
     */
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setDate($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPersist(){
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function onUpdate(){
        $this->updatedAt = new \DateTime();
    }

}