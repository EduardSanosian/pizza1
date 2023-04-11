<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Order1;
use App\Form\Order1Type;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    #[Route('/home')]
    public function showHome(EntityManagerInterface $entityManager){
        $category = $entityManager->getRepository(Category::class)->findAll();

        if (!$category) {
            throw $this->createNotFoundException(
                'No product found '
            );
        }

        return $this->render("bezoeker/home.html.twig", ['categorys' => $category]);

        }


    #[Route('/bestel/{id}')]
    public function showBestllen(EntityManagerInterface $entityManager, int $id){
        $category = $entityManager->getRepository(Category::class)->find($id);
        $product = $category->getProducts();

        return $this->render('bezoeker/bestel.html.twig', ['products' => $product]);

        }

    #[Route('/contact')]
    public function showContact(){

        return $this->render('bezoeker/contact.html.twig');

    }
    #[Route('/inloggen')]
    public function showInloggen(){

        return $this->render('bezoeker/inloggen.html.twig');

    }
    #[Route('/eindpagina' ,name: 'eindpagina')]
    public function showPagina(){

        return $this->render('bezoeker/eindpagina.html.twig');

    }

    #[Route('/order/{id}')]
    public function showOrder(int $id,Request $request, EntityManagerInterface $entityManager){

        $order = new Order1();

        $form = $this->createForm(type: Order1Type::class, data: $order);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $order = $form->getData();
            $order->setProduct($entityManager->getRepository(Product::class)->find($id));

            $entityManager->persist($order);
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('eindpagina');
        }


        return $this->renderForm('bezoeker/order.html.twig',[
            'departmentForm'=>$form
        ]);

    }


}
