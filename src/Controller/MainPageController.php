<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Calculation;
use App\Form\CalculationType;
use Doctrine\ORM\EntityManagerInterface;

class MainPageController extends AbstractController
{
    #[Route('/{id?}', name: 'app_main_page')]
    public function index(?int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $dataArray = [];
        $calculationRepo = $entityManager->getRepository(Calculation::class);
        $calculation = $calculationRepo->findOneBy(['id' => $id]);

        if ($calculation instanceof Calculation) {
            $calculation->calculate();
            $dataArray['answer'] = $calculation->getAnswer();
            $entityManager->remove($calculation);
            $entityManager->flush();
        }

        $calculation = new Calculation();
        $form = $this->createForm(CalculationType::class, $calculation);
        $dataArray['form'] = $form;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calculation = $form->getData();

            if ($form->get('calculate')->isClicked()) {
                $calculation->calculate();
                $dataArray['answer'] = $calculation->getAnswer();
            } elseif ($form->get('in_queue')->isClicked()) {
                $entityManager->persist($calculation);
                $entityManager->flush();
            }

            $dataArray['form'] = $this->createForm(CalculationType::class, new Calculation());
        }

        $dataArray['queue'] = $calculationRepo->getQueue();

        return $this->render('main_page/index.html.twig', $dataArray);
    }
}
