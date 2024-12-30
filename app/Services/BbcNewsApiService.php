<?php

namespace App\Services;

use Illuminate\Support\Facades\{
    Http,
    Log
};

class BbcNewsApiService
{

    /**
     * Fetch articles from the bbc-news API and store them in the database.
     *
     * @return void
     */
    public function fetchAndStoreArticles()
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'apiKey' => env('NEWSAPI_KEY'),
            'sources' => 'bbc-news',
        ]);

        if ($response->successful()) {
            $articles = $response->json()['articles'];
            resolve(ArticleSaverService::class)->saveArticle($articles, 'General');
        } else {
            Log::error('Failed to fetch articles: ' . $response->body());
        }

        Log::info('successful bbc fetch articles');
    }
}
