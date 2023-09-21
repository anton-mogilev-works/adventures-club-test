<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Calculation;
use App\Form\CalculationType;

class MainPageController extends AbstractController
{
    #[Route('/', name: 'app_main_page')]
    public function index(Request $request): Response
    {
        $calculation = new Calculation();

        $form = $this->createForm(CalculationType::class, $calculation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calculation = $form->getData();

        }

        return $this->render('main_page/index.html.twig', [
            'form' => $form,
        ]);
    }
}
