<?php

declare(strict_types=1);

namespace NorbertTech\Portfolio\EventListener;

use NorbertTech\Portfolio\Blog\Posts;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class SitemapSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly Posts $posts,
    ) {}

    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::class => 'populate',
        ];
    }

    public function populate(SitemapPopulateEvent $event): void
    {
        $this->populateBlogPosts($event);
    }

    private function populateBlogPosts(SitemapPopulateEvent $event): void
    {
        foreach ($this->posts->all('en') as $post) {
            $event->getUrlContainer()->addUrl(
                new UrlConcrete(
                    $event->getUrlGenerator()->generate(
                        'blog_post',
                        ['date' => $post->date->format('Y-m-d'), 'slug' => $post->slug],
                        UrlGeneratorInterface::ABSOLUTE_URL,
                    ),
                    changefreq: 'weekly',
                ),
                'blog',
            );
        }

        foreach (['pl', 'de', 'fr', 'es'] as $language) {
            foreach ($this->posts->all('pl') as $post) {
                $event->getUrlContainer()->addUrl(
                    new UrlConcrete(
                        $event->getUrlGenerator()->generate(
                            'blog_post_language',
                            ['date' => $post->date->format('Y-m-d'), 'slug' => $post->slug, 'language' => $language],
                            UrlGeneratorInterface::ABSOLUTE_URL,
                        ),
                        changefreq: 'weekly',
                    ),
                    'blog-' . $language,
                );
            }
        }
    }
}
