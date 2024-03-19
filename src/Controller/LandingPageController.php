<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Entity\User;
use App\Form\DeliveryType;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingPageController extends AbstractController
{
    #[Route('/', name: 'landing_page')]
    public function index(Request $request, User $user,UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        // crée une instance de chaque form
        $newuser = new User;
        $newdelivery = new Delivery;
        // crée un formulaire et instanciée $request
        $formuser = $this->createForm(UserType::class, $newuser);
        $formdelivery = $this->createForm(DeliveryType::class, $newdelivery);

        $formuser->handleRequest($request);
        $formdelivery->handleRequest($request);
        
        if ($formuser->isSubmitted() && $formuser->isValid()) {

            $newuser->setCreatedAt(new DateTimeImmutable());
            $newdelivery->setCreatedAt(new DateTimeImmutable());

            $newdelivery->setUser($newuser);

            $entityManager->persist($newdelivery);
            $entityManager->persist($newuser);

            $entityManager->flush();
            
        }
        return $this->render('landing_page/index_new.html.twig',[
            'form'=> $formuser,
            'formdelivery'=> $formdelivery
        ]);
    }

    #[Route('/confirmation', name: 'confirmation')]
    public function confirmation(): Response
    {
        return $this->render('landing_page/confirmation.html.twig');
    }
}