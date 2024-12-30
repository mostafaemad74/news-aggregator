<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Services\{
    NewYorkNewsApiService,
    BbcNewsApiService,
    NewsApiService
};

class FetchNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch-news-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new NewsApiService())->fetchAndStoreArticles();
        (new BbcNewsApiService())->fetchAndStoreArticles();
        (new NewYorkNewsApiService())->fetchAndStoreArticles();
        Log::info("Articles fetched successfully.");
        $this->info('News articles fetched successfully.');
    }
}
