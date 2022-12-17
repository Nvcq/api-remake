<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignUpController extends AbstractController
{
    #[Route('/sign/up', name: 'app_sign_up')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $user->setRoles(["ROLE_USER"]);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('sign_up/index.html.twig', [
            'form' => $form,
        ]);
    }
}
