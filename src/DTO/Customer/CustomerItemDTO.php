<?php
namespace App\DTO\Customer;

class CustomerItemDTO
{
    private int $id;

    private string $firstname;

    private string $lastname;

    private ?string $company;

    private ?string $job;

    public function __construct(
        int $id,
        string $firstname,
        string $lastname,
        ?string $company,
        ?string $job
    )
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->company = $company;
        $this->job = $job;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of firsntame
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get the value of company
     */ 
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Get the value of job
     */ 
    public function getJob()
    {
        return $this->job;
    }
}