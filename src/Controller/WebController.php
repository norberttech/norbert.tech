<?php

namespace NorbertTech\Portfolio\Controller;

use NorbertTech\Portfolio\Blog\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebController extends AbstractController
{
    #[Route('/', name: 'home', options: ['sitemap' => true])]
    public function index(Request $request, Posts $posts): Response
    {
        $latestPost = $posts->all('en')[0] ?? null;

        return $this->render('index.html.twig', [
            'latestPost' => $latestPost,
        ]);
    }
}
