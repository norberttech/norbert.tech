<?php

declare(strict_types=1);

namespace NorbertTech\Portfolio\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ConsultingController extends AbstractController
{
    #[Route('/consulting', name: 'consulting', options: ['sitemap' => true])]
    public function index(Request $request): Response
    {
        return $this->render('consulting/index.html.twig', []);
    }
}
