<?php

namespace App\Repositories\AirTable;

use App\AirtableDrawing;
use App\Site;
use Illuminate\Database\Eloquent\Model;

class DrawingRepository
{

    /**
     * Create resource with provided data
     * @param $data
     * @return AirtableDrawing
     */
    public function create($data)
    {
        $object = new AirtableDrawing();
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
     * @return AirtableDrawing[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        $collection = AirtableDrawing::all();
        return $collection;
    }

    /**
     * Delete a specific resource
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return AirtableDrawing::destroy($id);
    }
}
