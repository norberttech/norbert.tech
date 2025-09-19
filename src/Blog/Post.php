<?php

declare(strict_types=1);

namespace NorbertTech\Portfolio\Blog;

use function Flow\Types\DSL\type_boolean;
use function Flow\Types\DSL\type_integer;
use function Flow\Types\DSL\type_list;
use function Flow\Types\DSL\type_optional;
use function Flow\Types\DSL\type_string;
use function Flow\Types\DSL\type_structure;

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
        type_structure(
            [
                'id' => type_integer(),
                'title' => type_string(),
                'description' => type_string(),
                'date' => type_string(),
                'labels' => type_list(type_string()),
                'slug' => type_string(),
            ],
            [
                'language' => type_string(),
                'translations_ids' => type_list(type_integer()),
                'translated' => type_boolean(),
            ],
        )->assert($data);

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
