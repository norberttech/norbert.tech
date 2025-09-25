<?php

declare(strict_types=1);

namespace NorbertTech\Portfolio\StaticSourceProvider;

use NorbertTech\Portfolio\Blog\Posts;
use NorbertTech\StaticContentGeneratorBundle\Content\Source;
use NorbertTech\StaticContentGeneratorBundle\Content\SourceProvider;

final class BlogPostsProvider implements SourceProvider
{
    public function __construct() {}

    public function all(): array
    {
        $sources = [];
        $posts = new Posts();

        foreach ($posts->all('en') as $post) {
            $sources[] = new Source('blog_post', ['date' => $post->date->format('Y-m-d'), 'slug' => $post->slug]);
        }

        foreach ($posts->all('pl') as $post) {
            $sources[] = new Source('blog_post_language', [
                'date' => $post->date->format('Y-m-d'),
                'language' => 'pl',
                'slug' => $post->slug,
            ]);
        }

        foreach ($posts->all('de') as $post) {
            $sources[] = new Source('blog_post_language', [
                'date' => $post->date->format('Y-m-d'),
                'language' => 'de',
                'slug' => $post->slug,
            ]);
        }

        foreach ($posts->all('fr') as $post) {
            $sources[] = new Source('blog_post_language', [
                'date' => $post->date->format('Y-m-d'),
                'language' => 'fr',
                'slug' => $post->slug,
            ]);
        }

        foreach ($posts->all('es') as $post) {
            $sources[] = new Source('blog_post_language', [
                'date' => $post->date->format('Y-m-d'),
                'language' => 'es',
                'slug' => $post->slug,
            ]);
        }

        foreach ($posts->all('it') as $post) {
            $sources[] = new Source('blog_post_language', [
                'date' => $post->date->format('Y-m-d'),
                'language' => 'it',
                'slug' => $post->slug,
            ]);
        }

        $sources[] = new Source('blog_post_old_redirect', []);

        return $sources;
    }
}
