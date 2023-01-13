<?php

namespace App\Console\Commands;

use App\Jobs\AirtableSync;
use App\Repositories\AirTable\DrawingRepository;
use App\Repositories\AirTable\ModelRepository;
use App\Repositories\AirTable\ServiceRepository;
use App\Services\AirTable;
use Illuminate\Console\Command;
use App\Console\CommandUtility;

class SyncAirtableData extends Command
{
    use CommandUtility;

    protected $signature = 'airtable:sync_data';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();
    }

    public function handle()
    {
        try {
            /**
             * Group 3 - Task 5: Add a cron-job to run synchronization on daily basis.
             */
            AirtableSync::dispatch();
            $this->echo("Sync airtable data job pushed to queue");
        } catch (\Exception $exception) {
            $this->echoError($exception->getMessage());
        }
    }
}
