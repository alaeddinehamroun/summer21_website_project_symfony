<?php


namespace App\Utilities;


use Doctrine\ORM\Mapping as ORM;

trait TimeStampTrait
{
    /**
     * @var
     * @ORM\Column (dateTime)
     */
    private $date;



    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPersist(){
        $this->date = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function onUpdate(){
        $this->updatedAt = new \DateTime();
    }


}