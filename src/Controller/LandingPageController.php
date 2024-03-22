<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Entity\Payment;
use App\Entity\Product;
use App\Entity\User;
use App\Form\DeliveryType;
use App\Form\UserType;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\OrderBy;
use PhpParser\Node\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingPageController extends AbstractController
{
    #[Route('/', name: 'landing_page', methods: ['GET', 'POST'])]
    public function index(Request $request,ProductRepository $product, EntityManagerInterface $entityManager,User $user): Response
    {   
        $productsbyid = $product->findby([], ['price'=>'DESC']);

        // crée une instance de chaque form
        $newuser = new User;
        $newdelivery = new Delivery;
        $newpayment = new Payment;


        // crée un formulaire et instanciée $request
        $formuser = $this->createForm(UserType::class, $newuser);
        // $formdelivery = $this->createForm(DeliveryType::class, $newdelivery);

        $formuser->handleRequest($request);
        // $formdelivery->handleRequest($request);
        if ($formuser->isSubmitted() && $formuser->isValid()) {
            // dd($request);
            
            
            $valueorder = $request->get('order')['cart']['cart_products'][0];
            // récupérer method payment 
            $valuepayment = $request->get('order')['payment_method'];
            $newpayment->setMethodpayment($valuepayment);
            $productselect = $product->find($valueorder);
                        
            $newdelivery = $formuser->get('delivery')->getData();
           
            $newuser->setCreatedAt(new DateTimeImmutable());    
            $newdelivery->setCreatedAt(new DateTimeImmutable());
            $newpayment->setCreatedAt(new DateTimeImmutable());
            
            $newdelivery->setUser($newuser);
            $newdelivery->setProduct($productselect);
            $newdelivery->setPayment($newpayment);
        

            // $newproduct->setUser($newuser);
           
            $entityManager->persist($newdelivery);
            $entityManager->persist($newuser);
            

            $userserial = $newuser->__serialize();
            $newdelivery->__unserialize($userserial);
            $entityManager->flush();
            
            $this->jsonapp($newuser, $newdelivery);

            return $this->redirectToRoute('app_stripe',['id'=> $newdelivery->getId()]);
            
        }
        return $this->render('landing_page/index_new.html.twig',[
            'form'=> $formuser,
            'products'=>$productsbyid
           
        ]);
    }

    #[Route('/confirmation', name: 'confirmation')]

    public function confirmation(): Response
    {
        return $this->render('landing_page/confirmation.html.twig');
    }
    
    public function jsonapp(User $user,Delivery $delivery)
    {
        if ($delivery->isIsstatuspayment()) {
            $status = 'PAID';
        }else {
            $status = 'WAITING';
        }
        // dd($delivery);

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api-commerce.simplon-roanne.com/order', 
        [
            'headers' => [
                'Authorization' => 'Bearer mJxTXVXMfRzLg6ZdhUhM4F6Eutcm1ZiPk4fNmvBMxyNR4ciRsc8v0hOmlzA0vTaX'
            ],

            'json'=>[
                "order"=> [
                    "id"=> $delivery->getId(),
                    "product"=> $delivery->getProduct()->getName(),
                    "payment_method"=> $delivery->getPayment()->getMethodpayment(),
                    "status"=> $status,
                    "client"=> [
                        "firstname"=> $delivery->getUser()->getFirstname(),
                        "lastname"=> $delivery->getUser()->getLastname(),
                        "email"=> $delivery->getUser()->getEmail()
                        ],
                    "addresses"=> [
                        "billing"=> [
                            "address_line1"=> $user->getAdress(),
                            "address_line2"=> $user->getComplementadress(),
                            "city"=> $user->getCity(),
                            "zipcode"=> $user->getPostalcode(),
                            "country"=> $user->getCountry(),
                            "phone"=> $user->getPhonenumber()
                        ],
                        "shipping"=> [
                            "address_line1"=> $delivery->getAdress(),
                            "address_line2"=> $delivery->getComplement(),
                            "city"=> $delivery->getCity(),
                            "zipcode"=> $delivery->getComplement(),
                            "country"=> $delivery->getCountry(),
                            "phone"=> $delivery->getPhonenumber()
                        ]
                    ]
                ]
            ]
        ]);
    }
}
   