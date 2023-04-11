<?php

namespace App\Controller;

use App\Entity\Order1;
use App\Form\Order1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderenController extends AbstractController
{
    #[Route('/orderen')]
    public function newAction(Request $request, EntityManagerInterface $em): Response
    {
        $department= new Order1();
        $form= $this->createForm(Order1Type::class, $department);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $department = $form->getData();
            //$department->setProduct();

            $em->persist($department);
            $em->flush();
        }

        return $this->renderForm('bezoeker/order.html.twig', [
            'departmentForm' => $form,
        ]);
    }
}
