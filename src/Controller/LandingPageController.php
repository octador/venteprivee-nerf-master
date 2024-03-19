<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingPageController extends AbstractController
{
    #[Route('/', name: 'landing_page')]
    public function index(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $newuser = new User;

        $form = $this->createForm(UserType::class, $newuser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newuser->setCreatedAt(new DateTimeImmutable());
            $entityManager->persist($newuser);
            $entityManager->flush();
        }
        return $this->render('landing_page/index_new.html.twig',[
            'form'=>$form
        ]);
    }

    #[Route('/confirmation', name: 'confirmation')]
    public function confirmation(): Response
    {
        return $this->render('landing_page/confirmation.html.twig');
    }
}