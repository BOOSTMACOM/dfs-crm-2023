<?php
namespace App\DTO\Job;

use App\Entity\Job;

class JobItemDTO 
{
    private int $id;

    private string $title;

    public function __construct(int $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
}