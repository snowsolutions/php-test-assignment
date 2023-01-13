<?php

namespace App\Repositories\AirTable;

use App\AirtableService;
use App\Site;
use Illuminate\Database\Eloquent\Model;

class ServiceRepository
{

    /**
     * Create resource with provided data
     * @param $data
     * @return AirtableService
     */
    public function create($data)
    {
        $object = new AirtableService();
        $object->fill($data);
        $this->save($object);
        return $object;
    }

    /**
     * Save current object
     * @param $object
     * @return mixed
     */
    public function save($object) {
        return $object->save();
    }

    /**
     * Retrieve record by a specific id
     * @param int $id
     * @return mixed | Model
     */
    public function get(int $id)
    {
        return Site::findOrFail($id);
    }

    /**
     * Retrieve a collection of model
     * @return AirtableService[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        $collection = AirtableService::all();
        return $collection;
    }

    /**
     * Delete a specific resource
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return AirtableService::destroy($id);
    }
}
