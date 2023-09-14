<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Debug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug';

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
        Artisan::call('migrate');

        User::shouldBeStrict();

        User::factory()->create();
        $user = User::query()->select('id')->first();

        \Log::debug('Accessing password does not throw a MissingAttributeException because it is casted. This is unexpected behavior');
        $password = $user->password;

        \Log::debug('Accessing name throws a MissingAttributeException because it is not casted. This is the expected behavior');
        $name = $user->name;
    }
}
