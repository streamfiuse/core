<?php

namespace App\Console\Commands\Monitoring\Fiuselist;

use Illuminate\Console\Command;

class MonitorFiuselists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:fiuselists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitors all entries of the content_users table to meet all integrity constraints';

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
        $this->call('check:fiuselistIntegrity');
        $this->call('insure:fiuselistIntegrity');
    }
}
