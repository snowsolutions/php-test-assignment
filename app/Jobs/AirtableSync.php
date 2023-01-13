<?php

namespace App\Jobs;

use App\AirtableDrawing;
use App\AirtableModel;
use App\AirtableService;
use App\Helpers\Requestbin;
use App\Repositories\AirTable\DrawingRepository;
use App\Repositories\AirTable\ModelRepository;
use App\Repositories\AirTable\ServiceRepository;
use App\Services\AirTable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AirtableSync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var AirTable
     */
    protected $airTableService;

    /**
     * @var ModelRepository
     */
    protected $modelRepository;

    /**
     * @var DrawingRepository
     */
    protected $drawingRepository;

    /**
     * @var ServiceRepository
     */
    protected $serviceRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->airTableService = \app()->make(AirTable::class);
        $this->modelRepository = \app()->make(ModelRepository::class);
        $this->drawingRepository = \app()->make(DrawingRepository::class);
        $this->serviceRepository = \app()->make(ServiceRepository::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $totalRecordCreated = [
            'model_created' => 0,
            'drawing_created' => 0,
            'service_created' => 0,
        ];
        /**
         * Group 3 - Task 5: Implement a script to gather data from API and store it to created tables.
         */

        $queueStart = microtime(true);
        $this->airTableService->getConnection();
        $this->airTableService->setConnectionToken(env('AIRTABLE_ACCESS_KEY'));
        $this->airTableService->setConnectionBaseId(env('AIRTABLE_BASE_ID'));

        /**
         * Sync model table
         */
        AirtableModel::query()->truncate();
        $modelSyncStart = microtime(true);
        $modelData = $this->airTableService->getAllRecords(AirTable::AIRTABLE_TABLE_MODEL_ID);
        foreach ($modelData as $rowData) {
            try {
                if (array_key_exists('parents', $rowData)) {
                    $rowData['parents'] = json_encode($rowData['parents']);
                }
                if (array_key_exists('children', $rowData)) {
                    $rowData['children'] = json_encode($rowData['children']);
                }
                if (array_key_exists('services', $rowData)) {
                    $rowData['services'] = json_encode($rowData['services']);
                }
                $this->modelRepository->create($rowData);
                $totalRecordCreated['model_created']++;
            } catch (\Exception $exception) {
                echo $exception->getMessage() . "\n";
            }
        }
        $this->airTableService->resetAllRecords();
        $modelSyncTime = round(microtime(true) - $modelSyncStart, 2);
        echo "Sync model table complete in $modelSyncTime (s)\n";

        /**
         * Sync drawing table
         */
        AirtableDrawing::query()->truncate();
        $drawingSyncStart = microtime(true);
        $drawingData = $this->airTableService->getAllRecords(AirTable::AIRTABLE_TABLE_DRAWING);
        foreach ($drawingData as $drawingRowData) {
            try {
                if (array_key_exists('model_model', $drawingRowData)) {
                    $drawingRowData['model_model'] = json_encode($drawingRowData['model_model']);
                }
                $this->drawingRepository->create($drawingRowData);
                $totalRecordCreated['drawing_created']++;

            } catch (\Exception $exception) {
                echo $exception->getMessage() . "\n";
            }
        }
        $this->airTableService->resetAllRecords();
        $drawingSyncTime = round(microtime(true) - $drawingSyncStart, 2);
        echo "Sync drawing table complete in $drawingSyncTime (s)\n";

        /**
         * Sync service table
         */
        AirtableService::query()->truncate();
        $serviceSyncStart = microtime(true);
        $serviceData = $this->airTableService->getAllRecords(AirTable::AIRTABLE_TABLE_SERVICE);
        foreach ($serviceData as $serviceRowData) {
            try {
                if (array_key_exists('model', $serviceRowData)) {
                    $serviceRowData['model'] = json_encode($serviceRowData['model']);
                }
                if (array_key_exists('id', $serviceRowData)) {
                    $serviceRowData['service_id'] = json_encode($serviceRowData['id']);
                }
                $this->serviceRepository->create($serviceRowData);
                $totalRecordCreated['service_created']++;
            } catch (\Exception $exception) {
                echo $exception->getMessage() . "\n";
            }
        }
        $this->airTableService->resetAllRecords();
        $serviceSyncTime = round(microtime(true) - $serviceSyncStart, 2);
        echo "Sync service table complete in $serviceSyncTime (s)\n";

        $queueProcessTime = round(microtime(true) - $queueStart, 2);

        echo "Total Queue process in $queueProcessTime (s)\n";

        /**
         * Ping Requestbin
         */
        Requestbin::ping($totalRecordCreated);

        echo "Ping total records created to Requestbin\n";
    }
}
