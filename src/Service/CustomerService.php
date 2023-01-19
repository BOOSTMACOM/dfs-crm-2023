<?php
namespace App\Service;

use App\Entity\User;
use App\Entity\Customer;
use App\Service\AppServiceInterface;
use App\DTO\Customer\CustomerItemDTO;
use App\Repository\CustomerRepository;
use App\Cmd\Customer\EditCustomerFormCmd;
use App\Repository\CompanyRepository;

class CustomerService implements AppServiceInterface
{

    private CustomerRepository $repository;

    private CompanyRepository $companyRepository;

    public function __construct(CustomerRepository $repository, CompanyRepository $companyRepository)
    {
        $this->repository = $repository;
        $this->companyRepository = $companyRepository;
    }

    public function getAll()
    {
        return $this->getAllQuery()->getResult();
    }

    public function getAllQuery()
    {
        $query = 'NEW ' . CustomerItemDTO::class . '(c.id,c.firstname,c.lastname, co.name, j.title)';
        return $this->repository->createQueryBuilder('c')
        ->select($query)
        ->leftJoin('c.company','co')
        ->leftJoin('c.job','j')
        ->getQuery();
    }

    public function get(int $id)
    {
        $query = 'NEW ' . CustomerItemDTO::class . '(c.id,c.firstname,c.lastname, co.name, j.title)';
        return $this->repository->createQueryBuilder('c')
        ->select($query)
        ->leftJoin('c.company','co')
        ->leftJoin('c.job','j')
        ->where('c.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getSingleResult();
    }

    public function create(EditCustomerFormCmd $cmd, User $currentUser) : void
    {
        $customer = (new Customer())
        ->setFirstname($cmd->getFirstname())
        ->setLastname(strtoupper($cmd->getLastname()))
        ->setEmail($cmd->getEmail())
        ->setCreatedBy($currentUser);

        if($cmd->getCompany())
            $customer->setCompany($cmd->getCompany());

        if($cmd->getJob())
            $customer->setJob($cmd->getJob());

        $this->repository->save($customer, true);
    }

    public function update()
    {

    }

    public function delete()
    {

    }


}