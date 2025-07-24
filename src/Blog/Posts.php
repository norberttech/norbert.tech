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
        ],
        [
            'id' => 2,
            'title' => 'Testing Stimulus - minimalistic approach',
            'labels' => ['stimulus', 'testing'],
            'description' => 'Testing Stimulus controllers with absolute minimalistic approach. With only built in test runner, assert and JSDOM library',
            'date' => '2024-09-20',
            'slug' => 'testing-stimulus-minimalistic-approach'
        ],
        [
            'id' => 3,
            'title' => 'How I use AI to automate boring coding tasks',
            'labels' => ['AI', 'automation', 'PHP', 'development', 'claude'],
            'description' => 'A practical walkthrough of using Claude Code Agent to implement 27+ Symfony String functions in Flow PHP, breaking down complex tasks into manageable automated workflows.',
            'date' => '2025-07-22',
            'slug' => 'ai-automate-boring-coding-tasks'
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
        $posts = \array_map(
            static fn (array $data) : Post => Post::fromArray($data),
            $this->posts
        );

        return \array_reverse($posts);
    }
}