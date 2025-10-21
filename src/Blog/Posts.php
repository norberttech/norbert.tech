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
            'slug' => 'home-assistant-historical-statistics',
            'language' => 'en',
        ],
        [
            'id' => 2,
            'title' => 'Testing Stimulus - minimalistic approach',
            'labels' => ['stimulus', 'testing'],
            'description' => 'Testing Stimulus controllers with absolute minimalistic approach. With only built in test runner, assert and JSDOM library',
            'date' => '2024-09-20',
            'slug' => 'testing-stimulus-minimalistic-approach',
            'language' => 'en',
        ],
        [
            'id' => 3,
            'title' => 'How I use AI to automate boring coding tasks',
            'labels' => ['AI', 'automation', 'PHP', 'development', 'claude'],
            'description' => 'A practical walkthrough of using Claude Code Agent to implement 27+ Symfony String functions in Flow PHP, breaking down complex tasks into manageable automated workflows.',
            'date' => '2025-07-22',
            'slug' => 'ai-automate-boring-coding-tasks',
            'language' => 'en',
        ],
        [
            'id' => 4,
            'title' => 'Analiza danych w rozproszonych systemach transakcyjnych',
            'labels' => ['analiza danych', 'magazyn danych', 'ETL', 'przetwarzanie danych', 'systemy transakcyjne'],
            'description' => 'Czy Twój system transakcyjny pada pod naporem raportów? Szukasz sposobu na zbudowanie jednolitego źródła danych dla rozproszonego systemu? Dowiedz się, w jaki sposób zacząć zbudować wydajny magazyn danych analitycznych oraz jak uniknąć podstawowych.',
            'date' => '2025-08-12',
            'slug' => 'analiza-danych-w-rozproszonych-systemach-transakcyjnych',
            'language' => 'pl',
            'translations_ids' => [5, 6, 7, 8, 10],
        ],
        [
            'id' => 5,
            'title' => 'Data Analytics in Distributed Transactional Systems',
            'labels' => ['data analytics', 'data warehouse', 'ETL', 'data processing', 'transactional systems'],
            'description' => 'Is your transactional system crashing under the weight of reports? Looking for a way to build a unified data source for your distributed system? Learn how to start building an efficient analytical data warehouse and avoid common pitfalls.',
            'date' => '2025-08-12',
            'slug' => 'data-analytics-in-distributed-transactional-systems',
            'language' => 'en',
            'translations_ids' => [4, 6, 7, 8, 10],
            'translated' => true,
        ],
        [
            'id' => 6,
            'title' => 'Analyse de données dans les systèmes transactionnels distribués',
            'labels' => [
                'analyse de données',
                'entrepôt de données',
                'ETL',
                'traitement de données',
                'systèmes transactionnels',
            ],
            'description' => 'Votre système transactionnel s\'effondre sous le poids des rapports ? Vous cherchez un moyen de construire une source de données unifiée pour votre système distribué ? Découvrez comment commencer à construire un entrepôt de données analytiques efficace et éviter les pièges courants.',
            'date' => '2025-08-12',
            'slug' => 'analyse-donnees-systemes-transactionnels-distribues',
            'language' => 'fr',
            'translations_ids' => [4, 5, 7, 8, 10],
            'translated' => true,
        ],
        [
            'id' => 7,
            'title' => 'Datenanalyse in verteilten Transaktionssystemen',
            'labels' => ['Datenanalyse', 'Data Warehouse', 'ETL', 'Datenverarbeitung', 'Transaktionssysteme'],
            'description' => 'Bricht Ihr Transaktionssystem unter der Last von Berichten zusammen? Suchen Sie nach einer Möglichkeit, eine einheitliche Datenquelle für Ihr verteiltes System zu schaffen? Erfahren Sie, wie Sie ein effizientes analytisches Data Warehouse aufbauen und häufige Fallstricke vermeiden.',
            'date' => '2025-08-12',
            'slug' => 'datenanalyse-in-verteilten-transaktionssystemen',
            'language' => 'de',
            'translations_ids' => [4, 5, 6, 8, 10],
            'translated' => true,
        ],
        [
            'id' => 8,
            'title' => 'Análisis de Datos en Sistemas Transaccionales Distribuidos',
            'labels' => [
                'análisis de datos',
                'almacén de datos',
                'ETL',
                'procesamiento de datos',
                'sistemas transaccionales',
            ],
            'description' => '¿Tu sistema transaccional se colapsa bajo el peso de los informes? ¿Buscas una forma de construir una fuente de datos unificada para tu sistema distribuido? Aprende cómo comenzar a construir un almacén de datos analíticos eficiente y evitar las trampas comunes.',
            'date' => '2025-08-12',
            'slug' => 'analisis-datos-sistemas-transaccionales-distribuidos',
            'language' => 'es',
            'translations_ids' => [4, 5, 6, 7, 10],
            'translated' => true,
        ],
        [
            'id' => 10,
            'title' => 'Analisi dei Dati nei Sistemi Transazionali Distribuiti',
            'labels' => [
                'analisi dei dati',
                'data warehouse',
                'ETL',
                'elaborazione dati',
                'sistemi transazionali',
            ],
            'description' => 'Il tuo sistema transazionale crolla sotto il peso dei report? Cerchi un modo per costruire una fonte dati unificata per il tuo sistema distribuito? Scopri come iniziare a costruire un data warehouse analitico efficiente ed evitare le insidie comuni.',
            'date' => '2025-08-12',
            'slug' => 'analisi-dati-sistemi-transazionali-distribuiti',
            'language' => 'it',
            'translations_ids' => [4, 5, 6, 7, 8],
            'translated' => true,
        ],
        [
            'id' => 9,
            'title' => 'Parquet - Wprowadzenie',
            'labels' => [
                'parquet',
                'binarny',
                'kolumnowy',
                'format plików',
                'kompresja danych',
                'metadata',
                'szyfrowanie',
                'Apache Thrift',
                'Flow PHP',
            ],
            'description' => 'Kompletny przewodnik po Apache Parquet - binarnym, kolumnowym formacie plików. Dowiedz się jak osiągnąć 10x mniejsze pliki, wykorzystać metadata do błyskawicznego filtrowania, zrozumieć strukturę Row Groups i Data Pages, oraz poznać zaawansowane funkcje jak szyfrowanie i algorytmy Dremel.',
            'slug' => 'parquet-wprowadzenie',
            'language' => 'pl',
            'date' => '2025-09-20',
            'translations_ids' => [11, 12, 13, 14, 15],
        ],
        [
            'id' => 11,
            'title' => 'Parquet - Einführung',
            'labels' => [
                'Parquet',
                'binär',
                'spaltenorientiert',
                'Dateiformat',
                'Datenkompression',
                'Metadaten',
                'Verschlüsselung',
                'Apache Thrift',
                'Flow PHP',
            ],
            'description' => 'Vollständiger Leitfaden zu Apache Parquet - dem binären, spaltenorientierten Dateiformat. Erfahren Sie, wie Sie 10x kleinere Dateien erreichen, Metadaten für blitzschnelle Filterung nutzen, die Struktur von Row Groups und Data Pages verstehen und erweiterte Funktionen wie Verschlüsselung und Dremel-Algorithmen kennenlernen.',
            'slug' => 'parquet-einfuehrung',
            'language' => 'de',
            'date' => '2025-09-20',
            'translations_ids' => [9, 12, 13, 14, 15],
            'translated' => true,
        ],
        [
            'id' => 12,
            'title' => 'Parquet - Introducción',
            'labels' => [
                'parquet',
                'binario',
                'columnar',
                'formato de archivos',
                'compresión de datos',
                'metadatos',
                'cifrado',
                'Apache Thrift',
                'Flow PHP',
            ],
            'description' => 'Guía completa de Apache Parquet - el formato de archivos binario y columnar. Aprende cómo lograr archivos 10x más pequeños, utilizar metadatos para filtrado ultrarrápido, comprender la estructura de Row Groups y Data Pages, y conocer funciones avanzadas como cifrado y algoritmos Dremel.',
            'slug' => 'parquet-introduccion',
            'language' => 'es',
            'date' => '2025-09-20',
            'translations_ids' => [9, 11, 13, 14, 15],
            'translated' => true,
        ],
        [
            'id' => 13,
            'title' => 'Parquet - Introduction',
            'labels' => [
                'parquet',
                'binary',
                'columnar',
                'file format',
                'data compression',
                'metadata',
                'encryption',
                'Apache Thrift',
                'Flow PHP',
            ],
            'description' => 'Complete guide to Apache Parquet - the binary, columnar file format. Learn how to achieve 10x smaller files, use metadata for lightning-fast filtering, understand Row Groups and Data Pages structure, and explore advanced features like encryption and Dremel algorithms.',
            'slug' => 'parquet-introduction',
            'language' => 'en',
            'date' => '2025-09-20',
            'translations_ids' => [9, 11, 12, 14, 15],
            'translated' => true,
        ],
        [
            'id' => 14,
            'title' => 'Parquet - Introduzione',
            'labels' => [
                'parquet',
                'binario',
                'colonnare',
                'formato file',
                'compressione dati',
                'metadati',
                'crittografia',
                'Apache Thrift',
                'Flow PHP',
            ],
            'description' => 'Guida completa ad Apache Parquet - il formato di file binario e colonnare. Scopri come ottenere file 10 volte più piccoli, utilizzare i metadati per filtraggio ultrarapido, comprendere la struttura di Row Groups e Data Pages, ed esplorare funzionalità avanzate come crittografia e algoritmi Dremel.',
            'slug' => 'parquet-introduzione',
            'language' => 'it',
            'date' => '2025-09-20',
            'translations_ids' => [9, 11, 12, 13, 15],
            'translated' => true,
        ],
        [
            'id' => 15,
            'title' => 'Parquet - Introduction',
            'labels' => [
                'parquet',
                'binaire',
                'colonnaire',
                'format de fichier',
                'compression de données',
                'métadonnées',
                'chiffrement',
                'Apache Thrift',
                'Flow PHP',
            ],
            'description' => 'Guide complet d\'Apache Parquet - le format de fichier binaire et colonnaire. Apprenez comment obtenir des fichiers 10x plus petits, utiliser les métadonnées pour un filtrage ultra-rapide, comprendre la structure des Row Groups et Data Pages, et explorer les fonctionnalités avancées comme le chiffrement et les algorithmes Dremel.',
            'slug' => 'parquet-introduction-fr',
            'language' => 'fr',
            'date' => '2025-09-20',
            'translations_ids' => [9, 11, 12, 13, 14],
            'translated' => true,
        ],
        [
            'id' => 16,
            'title' => 'Mroczne strony modularyzacji',
            'labels' => ['modularyzacja', 'architektura', 'rozwój oprogramowania'],
            'description' => 'Praktyczne wyzwania modularyzacji systemów - jak rozwiązać problem sprzężenia na poziomie bazy danych, kiedy trzeba wydzielić moduł z monolitu. Porównanie podejść: separacja odpowiedzialności, projekcje, zdarzenia anemiczne a także materialized views.',
            'slug' => 'mroczne-strony-modularyzacji',
            'language' => 'pl',
            'date' => '2025-10-18',
            'translations_ids' => [],
        ],
    ];

    public function findByDateAndSlug(string $date, string $slug, string $language = 'en'): Post
    {
        foreach ($this->posts as $post) {
            if ($post['date'] === $date && $post['slug'] === $slug && $post['language'] === $language) {
                return Post::fromArray($post);
            }
        }

        throw new InvalidArgumentException('Post not found');
    }

    public function get(int $id): Post
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
    public function all(string $language = 'en'): array
    {
        $filteredPosts = \array_filter($this->posts, static fn(array $post): bool => $post['language'] === $language);

        $posts = \array_map(static fn(array $data): Post => Post::fromArray($data), $filteredPosts);

        return \array_reverse($posts);
    }

    /**
     * @return array<Post>
     */
    public function allLanguages(): array
    {
        $posts = \array_map(static fn(array $data): Post => Post::fromArray($data), $this->posts);

        return \array_reverse($posts);
    }
}
