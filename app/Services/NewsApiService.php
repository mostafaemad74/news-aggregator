<?php

namespace App\Services;

use Illuminate\Support\Facades\{
    Http,
    Log
};

class NewsApiService
{
    /**
     * Fetch articles from the News API and store them in the database.
     *
     * @return void
     */
    public function fetchAndStoreArticles()
    {
        $response = Http::get('https://newsapi.org/v2/everything', [
            'apiKey' => env('NEWSAPI_KEY'),
            'q' => 'bitcoin',

        ]);

        if ($response->successful()) {
            $articles = $response->json()['articles'];
            resolve(ArticleSaverService::class)->saveArticle($articles, 'Bitcoin');
        } else {
            Log::error('Failed to fetch articles: ' . $response->body());
        }

        Log::info('successful newsapi fetch articles');
    }
}
