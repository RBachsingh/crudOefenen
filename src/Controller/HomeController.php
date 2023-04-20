<?php

namespace App\Controller;

use App\Entity\Auto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function insertCars(EntityManagerInterface $entityManager): Response
    {
        $product = new Auto();
        $product->setModel();
        $product->setType();
        $product->setKleur();
        $product->setGewicht();
        $product->setPrijs();
        $product->setVoorraad();

        $entityManager->persist($product);

        $entityManager->flush();
        return $this->redirectToRoute('home/index.html.twig',[
            ''
        ]);
    }
}
