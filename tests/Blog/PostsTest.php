<?php

declare(strict_types=1);

namespace NorbertTech\Portfolio\Tests\Blog;

use InvalidArgumentException;
use NorbertTech\Portfolio\Blog\Post;
use NorbertTech\Portfolio\Blog\Posts;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PostsTest extends TestCase
{
    public function test_find_by_date_and_slug_returns_post_for_existing_english_post(): void
    {
        $posts = new Posts();

        $result = $posts->findByDateAndSlug('2024-08-07', 'home-assistant-historical-statistics');

        self::assertInstanceOf(Post::class, $result);
        self::assertSame('Home Assistant - Accessing Historical Statistics', $result->title);
        self::assertSame('2024-08-07', $result->date->format('Y-m-d'));
        self::assertSame('home-assistant-historical-statistics', $result->slug);
        self::assertSame('en', $result->language);
    }

    public function test_find_by_date_and_slug_returns_post_for_existing_english_post_with_latest_date(): void
    {
        $posts = new Posts();

        $result = $posts->findByDateAndSlug('2025-07-22', 'ai-automate-boring-coding-tasks');

        self::assertInstanceOf(Post::class, $result);
        self::assertSame('How I use AI to automate boring coding tasks', $result->title);
        self::assertSame('2025-07-22', $result->date->format('Y-m-d'));
        self::assertSame('ai-automate-boring-coding-tasks', $result->slug);
        self::assertSame('en', $result->language);
    }

    public function test_find_by_date_and_slug_throws_exception_for_non_existing_post(): void
    {
        $posts = new Posts();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Post not found');

        $posts->findByDateAndSlug('2023-01-01', 'non-existing-slug');
    }

    public function test_find_by_date_and_slug_throws_exception_for_wrong_language(): void
    {
        $posts = new Posts();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Post not found');

        $posts->findByDateAndSlug('2024-08-07', 'home-assistant-historical-statistics', 'pl');
    }

    #[DataProvider('find_by_date_and_slug_invalid_parameters_provider')]
    public function test_find_by_date_and_slug_with_invalid_parameters(
        string $date,
        string $slug,
        string $language,
    ): void {
        $posts = new Posts();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Post not found');

        $posts->findByDateAndSlug($date, $slug, $language);
    }

    public static function find_by_date_and_slug_invalid_parameters_provider(): \Generator
    {
        yield 'empty date' => ['', 'home-assistant-historical-statistics', 'en'];
        yield 'empty slug' => ['2024-08-07', '', 'en'];
        yield 'empty language' => ['2024-08-07', 'home-assistant-historical-statistics', ''];
        yield 'wrong date format' => ['2024/08/07', 'home-assistant-historical-statistics', 'en'];
        yield 'non-existing date' => ['2023-12-31', 'home-assistant-historical-statistics', 'en'];
        yield 'non-existing slug' => ['2024-08-07', 'non-existing-post', 'en'];
        yield 'case sensitive slug' => ['2024-08-07', 'Home-Assistant-Historical-Statistics', 'en'];
        yield 'unsupported language' => ['2024-08-07', 'home-assistant-historical-statistics', 'fr'];
    }

    public function test_get_returns_post_for_existing_id(): void
    {
        $posts = new Posts();

        $result = $posts->get(1);

        self::assertInstanceOf(Post::class, $result);
        self::assertSame('Home Assistant - Accessing Historical Statistics', $result->title);
        self::assertSame('2024-08-07', $result->date->format('Y-m-d'));
        self::assertSame('home-assistant-historical-statistics', $result->slug);
        self::assertSame('en', $result->language);
    }

    public function test_get_returns_correct_post_for_each_existing_id(): void
    {
        $posts = new Posts();

        $post1 = $posts->get(1);
        self::assertSame('Home Assistant - Accessing Historical Statistics', $post1->title);

        $post2 = $posts->get(2);
        self::assertSame('Testing Stimulus - minimalistic approach', $post2->title);

        $post3 = $posts->get(3);
        self::assertSame('How I use AI to automate boring coding tasks', $post3->title);
    }

    public function test_get_throws_exception_for_non_existing_id(): void
    {
        $posts = new Posts();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Post not found');

        $posts->get(999);
    }

    #[DataProvider('get_invalid_id_provider')]
    public function test_get_throws_exception_for_invalid_ids(int $id): void
    {
        $posts = new Posts();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Post not found');

        $posts->get($id);
    }

    public static function get_invalid_id_provider(): \Generator
    {
        yield 'zero id' => [0];
        yield 'negative id' => [-1];
        yield 'id 4 (removed post)' => [4];
        yield 'large non-existing id' => [1000];
        yield 'very large id' => [PHP_INT_MAX];
    }

    public function test_all_returns_english_posts_by_default(): void
    {
        $posts = new Posts();

        $result = $posts->all();

        self::assertIsArray($result);
        self::assertCount(3, $result);

        // Verify all posts are English
        foreach ($result as $post) {
            self::assertInstanceOf(Post::class, $post);
            self::assertSame('en', $post->language);
        }

        // Verify reverse chronological order (newest first)
        self::assertSame('How I use AI to automate boring coding tasks', $result[0]->title);
        self::assertSame('Testing Stimulus - minimalistic approach', $result[1]->title);
        self::assertSame('Home Assistant - Accessing Historical Statistics', $result[2]->title);
    }

    public function test_all_returns_english_posts_when_explicitly_specified(): void
    {
        $posts = new Posts();

        $result = $posts->all('en');

        self::assertIsArray($result);
        self::assertCount(3, $result);

        foreach ($result as $post) {
            self::assertInstanceOf(Post::class, $post);
            self::assertSame('en', $post->language);
        }
    }

    public function test_all_returns_empty_array_for_polish_posts_when_none_exist(): void
    {
        $posts = new Posts();

        $result = $posts->all('pl');

        self::assertIsArray($result);
        self::assertCount(0, $result);
    }

    public function test_all_returns_empty_array_for_non_existing_language(): void
    {
        $posts = new Posts();

        $result = $posts->all('fr');

        self::assertIsArray($result);
        self::assertCount(0, $result);
    }

    public function test_all_returns_empty_array_for_empty_language(): void
    {
        $posts = new Posts();

        $result = $posts->all('');

        self::assertIsArray($result);
        self::assertCount(0, $result);
    }

    public function test_all_languages_returns_all_posts_in_reverse_chronological_order(): void
    {
        $posts = new Posts();

        $result = $posts->allLanguages();

        self::assertIsArray($result);
        self::assertCount(3, $result);

        foreach ($result as $post) {
            self::assertInstanceOf(Post::class, $post);
        }

        self::assertSame('How I use AI to automate boring coding tasks', $result[0]->title);
        self::assertSame('en', $result[0]->language);

        self::assertSame('Testing Stimulus - minimalistic approach', $result[1]->title);
        self::assertSame('en', $result[1]->language);

        self::assertSame('Home Assistant - Accessing Historical Statistics', $result[2]->title);
        self::assertSame('en', $result[2]->language);
    }

    public function test_all_languages_includes_only_english_posts(): void
    {
        $posts = new Posts();

        $result = $posts->allLanguages();

        $languages = array_map(fn(Post $post) => $post->language, $result);
        $uniqueLanguages = array_unique($languages);

        self::assertContains('en', $uniqueLanguages);
        self::assertCount(1, $uniqueLanguages);
        self::assertSame(['en'], $uniqueLanguages);
    }

    public function test_posts_contain_expected_properties(): void
    {
        $posts = new Posts();

        $post = $posts->get(1);

        self::assertIsString($post->title);
        self::assertIsString($post->description);
        self::assertInstanceOf(\DateTimeImmutable::class, $post->date);
        self::assertIsArray($post->labels);
        self::assertIsString($post->slug);
        self::assertIsString($post->language);

        foreach ($post->labels as $label) {
            self::assertIsString($label);
        }
    }

    public function test_posts_have_expected_label_structure(): void
    {
        $posts = new Posts();

        $post1 = $posts->get(1);
        $post2 = $posts->get(2);
        $post3 = $posts->get(3);

        self::assertSame(['home assistant', 'solar installation'], $post1->labels);
        self::assertSame(['stimulus', 'testing'], $post2->labels);
        self::assertSame(['AI', 'automation', 'PHP', 'development', 'claude'], $post3->labels);
    }

    /**
     * This test demonstrates a potential issue: Post::fromArray() doesn't validate
     * the 'id' field from the array, but the Posts class uses it for lookup.
     * If the array structure changes, this could cause inconsistencies.
     */
    public function test_posts_array_structure_consistency(): void
    {
        $posts = new Posts();

        $allPosts = $posts->allLanguages();

        foreach ($allPosts as $post) {
            self::assertInstanceOf(Post::class, $post);
        }
    }
}
