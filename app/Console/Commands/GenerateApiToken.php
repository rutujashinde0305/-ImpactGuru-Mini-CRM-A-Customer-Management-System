<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateApiToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-api-token {--user=} {--name=api-token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an API token for a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user') ?: $this->ask('Enter user ID (leave empty for first user)');
        $tokenName = $this->option('name');

        if ($userId) {
            $user = User::find($userId);
        } else {
            $user = User::first();
        }

        if (!$user) {
            $this->error('User not found!');
            return 1;
        }

        $token = $user->createToken($tokenName)->plainTextToken;

        $this->info("API Token generated for user: {$user->name} (ID: {$user->id})");
        $this->line('');
        $this->line('Token Name: ' . $tokenName);
        $this->line('Token:');
        $this->line('');
        $this->comment($token);
        $this->line('');
        $this->warn('Keep this token safe! Use it in your API requests with:');
        $this->line('Authorization: Bearer ' . $token);

        return 0;
    }
}
