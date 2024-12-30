<?php

namespace App\Services;

use App\Models\Article;
use Carbon\Carbon;

class ArticleSaverService
{
    /**
     * Save an article to the database.
     *
     * @param array $article
     * @param string $category
     * @return void
     */
    public function saveArticle(array $articles, string $category = 'General')
    {
        foreach ($articles as $article) {
            Article::updateOrCreate(
                ['title' => $article['title']],
                [
                    'source' => $article['source']['name'] ?? $article['source'] ?? 'Unknown',
                    'author' => $article['author'] ?? $article['byline'] ?? 'Unknown',
                    'description' => $article['description'] ?? $article['abstract'] ?? null,
                    'url' => $article['url'] ?? null,
                    'url_to_image' => $article['urlToImage'] ?? $article['multimedia'][0]['url'] ?? null,
                    'content' => $article['content'] ?? $article['abstract'] ?? null,
                    'category' =>  $article['section'] ?? $category,
                    'published_at' => isset($article['publishedAt']) || isset($article['published_date'])
                        ? Carbon::parse($article['publishedAt'] ?? $article['published_date'])->format('Y-m-d H:i:s')
                        : null,
                ]
            );
        }
    }
}
