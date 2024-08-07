<?php

declare(strict_types=1);

namespace NorbertTech\Portfolio\Blog;

final class Posts
{
    private array $posts = [
        [
            'title' => 'Home Assistant - Accessing Historical Statistics',
            'labels' => ['home assistant', 'solar installation'],
            'description' => 'How to access historical statistics in home assistant.',
            'date' => '2024-08-07',
            'slug' => 'home-assistant-historical-statistics'
        ]
    ];

    /**
     * @return array<Post>
     */
    public function all() : array
    {
        return \array_map(
            static fn (array $data) : Post => new Post(
                $data['title'],
                $data['description'],
                new \DateTimeImmutable($data['date']),
                $data['labels'],
                $data['slug']
            ),
            $this->posts
        );
    }
}