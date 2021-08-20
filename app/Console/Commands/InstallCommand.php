<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teamway:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Teamway demo project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->welcome();

        $this->createEnvFile();
        $this->createDbFile();

        if (strlen(config('app.key')) === 0) {
            $this->call('key:generate');
        }

        $this->call('cache:clear');
        $this->call('config:cache');
        $this->call('migrate', ['--seed' => true]);

        $this->goodbye();
    }

    /**
     * Create the initial .env file.
     */
    protected function createEnvFile()
    {
        if (!file_exists('.env')) {
            copy('.env.example', '.env');

            $this->line('.env file successfully created');
        }
    }

    /**
     * Create the initial database.sqlite file.
     */
    protected function createDbFile()
    {
        if (!file_exists(database_path('database.sqlite'))) {
            touch(database_path('database.sqlite'));

            $this->line('Sqlite db successfully created');
        }
    }

    /**
     * Display the welcome message.
     */
    protected function welcome()
    {
        $this->info('>> Welcome to the Teamway installation process! <<');
    }


    /**
     * Display the completion message.
     */
    protected function goodbye()
    {
        $this->info('>> The installation process is complete! <<');
    }
}
