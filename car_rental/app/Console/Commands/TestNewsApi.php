<?php

namespace App\Console\Commands;

use App\Services\NewsApiService;
use Illuminate\Console\Command;

class TestNewsApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:test-api {count=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the News API integration';

    /**
     * Execute the console command.
     */
    public function handle(NewsApiService $newsApiService)
    {
        $count = $this->argument('count');
        
        $this->info("Testing News API with {$count} articles...");
        $apiKey = env('NEWS_API_KEY');
        $this->info("API Key: " . substr($apiKey, 0, 20) . "...");
        $this->info("API Key length: " . strlen($apiKey));
        $this->info("Starts with api_live_: " . (str_starts_with($apiKey, 'api_live_') ? 'Yes' : 'No'));
        $this->newLine();
        
        // Test fetching car news
        $this->info("Fetching car news...");
        $response = $newsApiService->fetchCarNews($count);
        
        if (isset($response['status']) && $response['status'] === 'error') {
            $this->error("API request failed!");
            $this->error("Please check storage/logs/laravel.log for details");
            
            // Try a direct test
            $this->newLine();
            $this->info("Attempting direct API test...");
            try {
                $testResponse = \Illuminate\Support\Facades\Http::get('http://api.mediastack.com/v1/news', [
                    'access_key' => $apiKey,
                    'keywords' => 'car',
                    'languages' => 'en',
                    'limit' => 3,
                ]);
                
                $this->info("Direct API Response Status: " . $testResponse->status());
                $this->line(json_encode($testResponse->json(), JSON_PRETTY_PRINT));
            } catch (\Exception $e) {
                $this->error("Direct test error: " . $e->getMessage());
            }
            
            return 1;
        }
        
        if (isset($response['status']) && $response['status'] === 'ok') {
            $this->info("✓ API request successful!");
            $this->info("Total results: " . ($response['totalResults'] ?? 0));
            $this->info("Articles fetched: " . count($response['articles'] ?? []));
            $this->newLine();
            
            // Display first few articles
            if (isset($response['articles']) && count($response['articles']) > 0) {
                $this->info("Sample Articles:");
                $this->newLine();
                
                foreach (array_slice($response['articles'], 0, 3) as $index => $article) {
                    $this->line("Article " . ($index + 1) . ":");
                    $this->line("  Title: " . ($article['title'] ?? 'N/A'));
                    $this->line("  Source: " . ($article['source']['name'] ?? 'N/A'));
                    $this->line("  Published: " . ($article['publishedAt'] ?? 'N/A'));
                    $this->line("  URL: " . ($article['url'] ?? 'N/A'));
                    $this->newLine();
                }
                
                $this->info("✓ News API is working correctly!");
                return 0;
            }
        }
        
        $this->error("Unable to fetch news. Check your API key and internet connection.");
        return 1;
    }
}
