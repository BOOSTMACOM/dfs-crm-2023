<?php

namespace App\Controller;

use App\Model\ActionModel;
use App\Service\JobService;
use App\Model\PaginatedDataModel;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JobController extends AbstractController
{
    #[Route('/job', name: 'app_job')]
    public function index(
        JobService $service, 
        PaginatorInterface $paginatorInterface,
        Request $request
    ): Response
    {

        $pagination = $paginatorInterface->paginate(
            $service->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('job/index.html.twig', [
            'paginated_data' => (new PaginatedDataModel($pagination, [
                'Titre' => 'title',
            ],[
                new ActionModel('Modifer','warning','app_company_edit'),
                new ActionModel('Détails','primary','app_company_show')
            ]
            ))->getData()
        ]);
    }
}
