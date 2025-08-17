<?php

declare(strict_types=1);

namespace NorbertTech\Portfolio\Blog;

final class Post
{
    /**
     * @param string $title
     * @param string $description
     * @param \DateTimeImmutable $date
     * @param array $labels
     * @param string $slug
     * @param string $language
     * @param array<int> $translationsIds
     */
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly \DateTimeImmutable $date,
        public readonly array $labels,
        public readonly string $slug,
        public readonly string $language = 'en',
        public readonly array $translationsIds = [],
        public readonly bool $translated = false,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'],
            $data['description'],
            new \DateTimeImmutable($data['date']),
            $data['labels'],
            $data['slug'],
            $data['language'] ?? 'en',
            $data['translations_ids'] ?? [],
            $data['translated'] ?? false,
        );
    }
}
