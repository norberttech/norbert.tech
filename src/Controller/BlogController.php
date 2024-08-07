<?php

namespace NorbertTech\Portfolio\Controller;

use NorbertTech\Portfolio\Blog\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog')]
    public function index() : Response
    {
        $posts = new Posts();

        return $this->render('blog/index.html.twig', [
            'posts' => $posts->all()
        ]);
    }

    #[Route('/blog/{date}/{slug}', name: 'blog_post')]
    public function post(string $date, string $slug) : Response
    {
        return $this->render('blog/posts/' . $date . '/' . $slug . '/post.html.twig', [
            'template_folder' => 'blog/posts/' . $date . '/' . $slug,
        ]);
    }
}
