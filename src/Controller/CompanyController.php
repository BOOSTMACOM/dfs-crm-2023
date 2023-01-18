<?php

namespace App\Controller;

use App\Entity\Company;
use App\Model\ActionModel;
use App\Model\PaginatedDataModel;
use App\Repository\CompanyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompanyController extends AbstractController
{
    #[Route('/entreprises', name: 'app_company_index')]
    public function index(
        CompanyRepository $companyRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $items = $paginator->paginate(
            $companyRepository->getPaginationQuery(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );    

        return $this->render('company/index.html.twig', [
            'paginated_data' => (new PaginatedDataModel($items, [
                'Nom' => 'name',
                'Adresse' => 'street',
                'Ville' => 'city',
                'CP' => 'zipCode'
            ], [
                new ActionModel('Modifer','warning','app_company_edit'),
                new ActionModel('Détails','primary','app_company_show')
            ]))->getData()
        ]);
    }

    #[Route('/entreprise/{id}', name: 'app_company_show')]
    public function show(Company $company)
    {
        return $this->render('company/show.html.twig', compact('company'));
    }

    #[Route('/entreprise/ajouter', name: 'app_company_add')]
    public function new(Request $request)
    {
        return $this->render('company/add.html.twig');
    }

    #[Route('/entreprise/{id}/modifier', name: 'app_company_edit')]
    public function edit(Company $company, Request $request)
    {
        return $this->render('company/edit.html.twig', compact('company'));
    }
}
