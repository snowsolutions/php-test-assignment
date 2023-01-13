<?php

namespace App\Helpers;

class AirTableConnection
{
    protected const GET_RECORDS_API_URL = 'https://api.airtable.com/v0/';
    protected const LIST_RECORDS_API_URL = 'https://api.airtable.com/v0/';
    /**
     * @var RestApi
     */
    protected $restApi;

    protected $connection = null;

    public function __construct(
        RestApi $restApi
    )
    {
        $this->restApi = $restApi;
    }

    /**
     * Init new connection object
     * @return void
     */
    public function initConnection()
    {
        $this->connection = new \stdClass();
    }

    /**
     * Retrieve connection object
     * @return mixed
     */
    public function getConnection()
    {
        if (is_null($this->connection)) {
            $this->initConnection();
        }
        return $this->connection;
    }

    /**
     * Set Token to connection object
     * @param $token
     * @return void
     */
    public function setToken($token)
    {
        $this->connection->token = $token;
    }

    public function setBaseId($baseId) {
        $this->connection->baseId = $baseId;
    }

    /**
     * Retrieve authorize header
     * @return string[]
     */
    protected function getAuthorizeHeader()
    {
        return [
            "Authorization: Bearer " . $this->connection->token
        ];
    }

    /**
     * Call API to get records and return the response
     * @return bool|string
     * @throws \Exception
     */
    public function getRecords($tableId, $data = [])
    {
        if (is_null($this->connection)) {
            throw new \Exception(__('Connection is not initialized'));
        }
        $getRecordUrl = self::GET_RECORDS_API_URL . $this->getConnection()->baseId . '/' . $tableId;
        return $this->restApi->call($getRecordUrl, 'GET', $this->getAuthorizeHeader(), $data);
    }
}
