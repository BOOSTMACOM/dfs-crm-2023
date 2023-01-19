<?php

namespace App\Controller\Api;

use App\Repository\CompanyRepository;
use App\Repository\CustomerRepository;
use App\Repository\JobRepository;
use App\Service\CustomerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatApiController extends AbstractController
{
    #[Route('/api/counters', name: 'app_api_counters')]
    public function index(
        CustomerRepository $customerRepository,
        CompanyRepository $companyRepository,
        JobRepository $jobRepository
    ): JsonResponse
    {
        $counters = [
            'customers' => count($customerRepository->findAll()),
            'companies' => count($companyRepository->findAll()),
            'jobs' => count($jobRepository->findAll())
        ];

        return $this->json($counters, 200, [
            'Access-Control-Allow-Origin' => '*'
        ]);
    }
}
