<?php

namespace App\Controller;

use App\Service\JobService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    #[Route('/job', name: 'app_job')]
    public function index(JobService $service): Response
    {
        return $this->render('job/index.html.twig', [
            'jobs' => $service->getAll(),
        ]);
    }
}
