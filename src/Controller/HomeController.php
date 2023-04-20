<?php

namespace App\Controller;

use App\Entity\Auto;
use App\Form\InsertType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function showCars(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(Auto::class)->findAll();

        return $this->render('home/index.html.twig', [
            'autos' => $products,
        ]);
    }
    #[Route('/insert', name:'app_insert')]
    public function insertCars(EntityManagerInterface $entityManager, Request $request): Response
    {
        $product = new Auto();
        $product->setModel();
        $product->setType();
        $product->setKleur();
        $product->setGewicht();
        $product->setPrijs();
        $product->setVoorraad();

        $form = $this->createForm(InsertType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $product = $form->getData();
            $entityManager->persist($form);

            $entityManager->flush();

            return $this->redirectToRoute('home/index.html.twig');
        }


        return $this->renderForm('home/insert.html.twig', [
            'form'=> $form,
        ]);

    }
}
