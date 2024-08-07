<?php

declare(strict_types=1);

namespace NorbertTech\Portfolio\Blog;

use InvalidArgumentException;

final class Posts
{
    private array $posts = [
        [
            'id' => 1,
            'title' => 'Home Assistant - Accessing Historical Statistics',
            'labels' => ['home assistant', 'solar installation'],
            'description' => 'How to access historical statistics in home assistant.',
            'date' => '2024-08-07',
            'slug' => 'home-assistant-historical-statistics'
        ]
    ];

    public function findByDateAndSlug(string $date, string $slug) : Post
    {
        foreach ($this->posts as $post) {
            if ($post['date'] === $date && $post['slug'] === $slug) {
                return Post::fromArray($post);
            }
        }

        throw new InvalidArgumentException('Post not found');
    }

    public function get(int $id) : Post
    {
        foreach ($this->posts as $post) {
            if ($post['id'] === $id) {
                return Post::fromArray($post);
            }
        }

        throw new InvalidArgumentException('Post not found');
    }

    /**
     * @return array<Post>
     */
    public function all() : array
    {
        return \array_map(
            static fn (array $data) : Post => Post::fromArray($data),
            $this->posts
        );
    }
}