<?php

namespace App\Controller;

use App\Entity\Auto;

use App\Form\AutoType;
use App\Form\InsertType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
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
        $product->setModel('');
        $product->setType('');
        $product->setKleur('');
        $product->setGewicht('0');
        $product->setPrijs('0');
        $product->setVoorraad('0');

        $modelIsRequired = true;
        $typeIsRequired = true;
        $kleurIsRequired = true;
        $gewichtIsRequired = true;
        $prijsIsRequired = true;
        $voorraadIsRequired = true;

        $form = $this->createFormBuilder($product)
            ->add('model', TextType::class)
            ->add('type', TextType::class)
            ->add('kleur', TextType::class)
            ->add('gewicht', NumberType::class)
            ->add('prijs', NumberType::class)
            ->add('voorraad', NumberType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Car'])
            ->getForm();

        $form = $this->createForm(InsertType::class, $product, [
            'require_model' => $modelIsRequired,
            'require_type' => $typeIsRequired,
            'require_kleur' => $kleurIsRequired,
            'require_gewicht' => $gewichtIsRequired,
            'require_prijs' => $prijsIsRequired,
            'require_voorraad' => $voorraadIsRequired,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->renderForm('home/insert.html.twig', [
            'form'=> $form,
        ]);

    }
    #[Route('/update/{id}',name:'app_update')]
    public function update(Request $request,EntityManagerInterface $entityManager, int $id)
    {
        $update=$entityManager->getRepository(Auto::class)->find($id);

        $form=$this->createForm(Auto::class,$update);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $update=$form->getData();
            $entityManager->persist($update);
            $entityManager->flush();
            return $this->redirectToRoute('app_home',[
                'id'=>$update->getId()
            ]);
        }
        return $this->renderForm('home/insert.html.twig', [
            'form'=>$form
        ]);
    }
    #[Route('/delete/{id}',name:'app_delete')]
    public function delete(Request $request,EntityManagerInterface $entityManager, int $id)
    {
        $delete=$entityManager->getRepository(Auto::class)->find($id);

        $form=$this->createForm(Auto::class,$delete);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $delete=$form->getData();
            $entityManager->remove($delete);
            $entityManager->flush();
            return $this->redirectToRoute('app_home',[
                'id'=>$delete->getId()
            ]);
        }
        return $this->renderForm('home/insert.html.twig', [
            'form'=>$form
        ]);
    }
}
