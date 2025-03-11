<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class BotSetWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * e.g. 'bot:set-webhook'
     */
    protected $signature = 'bot:set-webhook {url?}';

    /**
     * The console command description.
     */
    protected $description = 'Set the Telegram bot webhook to the specified URL or an environment-based URL.';

    public function handle()
    {
        // 1) Read the bot token from config (or .env)
        $token = config('services.telegram.bot_token');

        // 2) If a URL argument is provided, use that; otherwise read from .env or manual
        $webhookUrl = $this->argument('url') ?? env('NGROK_URL');

        if (!$webhookUrl) {
            $this->error('No webhook URL provided (argument or NGROK_URL env).');
            return 1;
        }

        // The final webhook endpoint will be e.g. https://xxxxxx.ngrok.io/bot-webhook
        $finalUrl = rtrim($webhookUrl, '/').'/api/bot-webhook';

        // 3) Build the Telegram setWebhook URL
        $telegramApiUrl = "https://api.telegram.org/bot{$token}/setWebhook?url={$finalUrl}&drop_pending_updates=true";

        // 4) Make an HTTP GET request
        $response = Http::get($telegramApiUrl);

        if ($response->successful()) {
            $this->info("Webhook set successfully to: {$finalUrl}");
            $this->info('Response: ' . $response->body());
            return 0;
        } else {
            $this->error('Failed to set webhook.');
            $this->error('Response: ' . $response->body());
            return 1;
        }
    }
}
