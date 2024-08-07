<?php

namespace NorbertTech\Portfolio\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request) : Response
    {
        return $this->render('index.html.twig', []);
    }
}
