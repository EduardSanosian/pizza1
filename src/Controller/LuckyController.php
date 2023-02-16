<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function showHome(){
        return $this->render("bezoeker/home.html.twig");

        }
    #[Route('/bestel')]
    public function showBestllen(){

        return $this->render('bezoeker/bestel.html.twig');

        }
}
