<?php

namespace App\Console\Commands\Monitoring\Fiuselist\Insure;

use App\Console\Commands\Monitoring\Fiuselist\Service\FiuselistDatabaseService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class FreeDislikedContentsFromUsersFiuselists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'free:dislikedContents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes the like_status to no_interaction on all rows where free_date is today';

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

     */
    public function handle(FiuselistDatabaseService $fiuselistDatabaseService): int
    {
        $fiuselistDatabaseService->freeDislikedContentsIfFreeDateIsReached();
        return 0;
    }
}
