<?php

namespace App\Services;

use Illuminate\Support\Facades\{
    Http,
    Log
};

class NewYorkNewsApiService
{
    /**
     * Fetch articles from the New York Times API and store them in the database.
     *
     * @return void
     */
    public function fetchAndStoreArticles()
    {
        $response = Http::get('https://api.nytimes.com/svc/news/v3/content/all/all.json', [
            'api-key' => env('GUARDIAN_API_KEY'),
        ]);

        if ($response->successful()) {
            $articles = $response->json()['results'];
            resolve(ArticleSaverService::class)->saveArticle($articles);
        } else {
            Log::error('Failed to fetch articles: ' . $response->body());
        }
        Log::info('successful nytimes fetch articles');
    }
}
