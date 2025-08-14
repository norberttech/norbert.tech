<?php

namespace NorbertTech\Portfolio\Controller;

use NorbertTech\Portfolio\Blog\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog')]
    public function index(): Response
    {
        $posts = new Posts();

        return $this->render('blog/index.html.twig', [
            'posts' => $posts->all(),
        ]);
    }

    #[Route('/blog/2025-01-22/ai-automate-boring-coding-tasks', name: 'blog_post_old_redirect')]
    public function redirectOldPost(): Response
    {
        return $this->render('blog/redirect.html.twig', [
            'new_url' => '/blog/2025-07-22/ai-automate-boring-coding-tasks',
            'post_title' => 'How I use AI to automate boring coding tasks',
        ]);
    }

    #[Route('/blog/{date}/{language}/{slug}', name: 'blog_post_language')]
    public function postLanguage(string $date, string $language, string $slug): Response
    {
        if ($language === 'en') {
            return new RedirectResponse($this->generateUrl('blog_post', ['date' => $date, 'slug' => $slug]), 301);
        }

        $post = (new Posts())->findByDateAndSlug($date, $slug, $language);

        return $this->render('blog/posts/' . $date . '/' . $slug . '/post.html.twig', [
            'post' => $post,
            'template_folder' => 'blog/posts/' . $date . '/' . $slug,
        ]);
    }

    #[Route('/blog/{date}/{slug}', name: 'blog_post')]
    public function post(string $date, string $slug): Response
    {
        $post = (new Posts())->findByDateAndSlug($date, $slug, 'en');

        return $this->render('blog/posts/' . $date . '/' . $slug . '/post.html.twig', [
            'post' => $post,
            'template_folder' => 'blog/posts/' . $date . '/' . $slug,
        ]);
    }
}
