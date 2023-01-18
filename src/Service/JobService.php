<?php
namespace App\Service;

use App\DTO\Job\JobItemDTO;
use App\Repository\JobRepository;
use App\Service\AppServiceInterface;

class JobService implements AppServiceInterface {

    private JobRepository $repository;

    public function __construct(JobRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        $jobs = $this->repository->findAll();
        $dtos = [];
        foreach($jobs as $job)
        {
            $dtos[] = new JobItemDTO($job);
        }
        return $dtos;
    }

    public function get(int $id)
    {

    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

}