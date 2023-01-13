<?php

namespace App\Services;

use App\Helpers\AirTableConnection;

class AirTable
{
    protected $airTableConnection;

    const AIRTABLE_TABLE_MODEL_ID = 'tblJcZyF08D5H1SYa';
    const AIRTABLE_TABLE_MODEL_MODEL_ID = 'tblU6UgDWv8gLZJgO';
    const AIRTABLE_TABLE_DRAWING = 'tblsuy0H84XcgBHem';
    const AIRTABLE_TABLE_SERVICE = 'tblycicIfqXoIcIo1';

    public function __construct(
        AirTableConnection $airTableConnection
    )
    {
        $this->airTableConnection = $airTableConnection;
    }

    public function getConnection()
    {
        $this->airTableConnection->getConnection();
    }

    public function setConnectionToken($token)
    {
        $this->airTableConnection->setToken($token);
    }
    public function setConnectionBaseId($baseId)
    {
        $this->airTableConnection->setBaseId($baseId);
    }

    protected $allRecords = [];

    /**
     * Retrieve all records of a table by looping while offset exist
     * @param $tableId
     * @param $data
     * @return array|mixed
     */
    public function getAllRecords($tableId = '', $data = []) {
        $records = $this->getRecords($tableId, $data);
        $this->allRecords = $this->allRecords + $records['data'];
        if (array_key_exists('offset', $records)) {
            $this->getAllRecords($tableId, ['offset' => $records['offset']]);
        }
        return $this->allRecords;
    }

    public function resetAllRecords() {
        $this->allRecords = [];
    }

    /**
     * Retrieve records from a table (pageSize = 100)
     * @param $tableId
     * @param $data
     * @return array[]
     * @throws \Exception
     */
    public function getRecords($tableId = '', $data = [])
    {
        $response = $this->airTableConnection->getRecords($tableId, $data);
        $responseArray = json_decode($response, true);
        $recordArray = $responseArray['records'];
        $records = [
            'data' => [],
        ];
        if (array_key_exists('offset', $responseArray)) {
            $records['offset'] = $responseArray['offset'];
        }
        foreach ($recordArray as $recordRowData) {
            $records['data'][$recordRowData['id']] = $recordRowData['fields'];
        }
        return $records;
    }


}
