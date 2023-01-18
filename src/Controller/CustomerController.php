<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerFormType;
use App\Model\ActionModel;
use App\Model\PaginatedDataModel;
use App\Repository\CustomerRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController
{
    #[Route('/clients', name: 'app_customers')]
    public function index(
        CustomerRepository $customerRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $items = $paginator->paginate(
            $customerRepository->getPaginationQuery(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );    

        return $this->render('customer/index.html.twig', [
            'paginated_data' => (new PaginatedDataModel($items, [
                'Nom' => 'lastname',
                'Prenom' => 'firstname',
                'Email' => 'email',
                'Entreprise' => 'company',
                'Créé par' => 'createdBy'
            ],[
                new ActionModel('Modifier','warning','app_customer_edit'),
                new ActionModel('Détails','primary','app_customer_edit')
            ]
            ))->getData()
        ]);
    }

    #[Route('/client/ajouter', name: 'app_customer_new')]
    public function new(Request $request, CustomerRepository $customerRepository) : Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerFormType::class, $customer);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // Mettre en persistence les données
            $customer->setCreatedBy($this->getUser());

            // On ajoute en bdd
            $customerRepository->save($customer, true);

            $this->addFlash('success', 'Client ajouté à la base de donnée');

            return $this->redirectToRoute('app_customers');
        }

        return $this->render('customer/edit.html.twig', [
            'new_customer_form' => $form->createView()
        ]);
    }

    #[Route('/client/modifier/{id}', name:"app_customer_edit")]
    public function edit(
        Customer $customer = null,
        Request $request, 
        CustomerRepository $customerRepository
    ) : Response
    {
        $form = $this->createForm(CustomerFormType::class, $customer);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // On ajoute en bdd
            $customerRepository->save($customer, true);

            $this->addFlash('success', 'Client modifié');

            return $this->redirectToRoute('app_customers');
        }

        return $this->render('customer/edit.html.twig', [
            'new_customer_form' => $form->createView()
        ]);
    }
}
