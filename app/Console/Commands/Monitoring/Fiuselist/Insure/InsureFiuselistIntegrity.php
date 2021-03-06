<?php

namespace App\Console\Commands\Monitoring\Fiuselist\Insure;

use Illuminate\Console\Command;

class InsureFiuselistIntegrity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insure:fiuselistIntegrity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insures fiuselist integrity by altering respective columns of table accordingly';

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
        $this->call('free:dislikedContents');
        return 0;
    }
}
