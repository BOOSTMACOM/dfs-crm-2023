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
        return $this->getAllQuery()->getResult();
    }

    public function getAllQuery()
    {
        $query = 'NEW ' . JobItemDTO::class . '(j.id, j.title)';
        return $this->repository->createQueryBuilder('j')->select($query)->getQuery();
    }

    public function get(int $id)
    {
        $job = $this->repository->find($id);
        return new JobItemDTO($job->getId(), $job->getTitle());
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