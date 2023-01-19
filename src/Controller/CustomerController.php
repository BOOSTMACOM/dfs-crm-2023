<?php

namespace App\Controller;

use App\Cmd\Customer\EditCustomerFormCmd;
use App\Entity\Customer;
use App\Model\ActionModel;
use App\Form\CustomerFormType;
use App\Form\EditCustomerFormType;
use App\Service\CustomerService;
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
        CustomerService $customerService,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $items = $paginator->paginate(
            $customerService->getAllQuery(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );    

        return $this->render('customer/index.html.twig', [
            'paginated_data' => (new PaginatedDataModel($items, [
                'Nom' => 'lastname',
                'Prenom' => 'firstname',
                'Poste' => 'job',
                'Entreprise' => 'company',
            ],[
                new ActionModel('Modifier','warning','app_customer_edit'),
                new ActionModel('Détails','primary','app_customer_edit')
            ]
            ))->getData()
        ]);
    }

    #[Route('/client/ajouter', name: 'app_customer_new')]
    public function new(Request $request, CustomerService $service) : Response
    {
        $cmd = new EditCustomerFormCmd();
        $form = $this->createForm(EditCustomerFormType::class, $cmd);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $service->create($cmd, $this->getUser());

            $this->addFlash('success', 'Client ajouté à la base de donnée');

            return $this->redirectToRoute('app_customers');
        }

        return $this->render('customer/edit.html.twig', [
            'new_customer_form' => $form->createView()
        ]);
    }

    #[Route('/client/modifier/{id}', name:"app_customer_edit")]
    public function edit(
        int $id,
        Request $request,
        CustomerService $service,
    ) : Response
    {

        try{
            $cmd = $service->getEditCustomerFormCmdFromEntityById($id);
            $form = $this->createForm(EditCustomerFormType::class, $cmd);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $service->update($id, $cmd);
                $this->addFlash('success', 'Client modifié');
                return $this->redirectToRoute('app_customers');
            }

            return $this->render('customer/edit.html.twig', [
                'new_customer_form' => $form->createView()
            ]);

        }
        catch(\Exception $e)
        {
            $this->addFlash('danger', $e->getMessage());
            return $this->redirectToRoute('app_customers');
        }
        
    }
}
