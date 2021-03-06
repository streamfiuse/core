<?php

namespace App\Console\Commands\Monitoring\Fiuselist\Check;

use Illuminate\Console\Command;

class CheckFiuselistsIntegrity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:fiuselistIntegrity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check whether all entries in the content_users table meet the integrity constraints';

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
        echo "Calling check fiuselist integrity command works|";
    }
}
