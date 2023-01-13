<?php

namespace App\Repositories\AirTable;

use App\AirtableModel;
use App\Site;
use Illuminate\Database\Eloquent\Model;

class ModelRepository
{

    /**
     * Create resource with provided data
     * @param $data
     * @return AirtableModel
     */
    public function create($data)
    {
        $object = new AirtableModel();
        $object->fill($data);
        $this->save($object);
        return $object;
    }

    /**
     * Update resource with provided data
     * @param $data
     * @return AirtableModel
     */
    public function update($number, $data)
    {
        $object = $this->getByNumber($number);
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

    public function isExist($number) {
        return AirtableModel::all()->where('number', $number)->isNotEmpty();
    }

    /**
     * Retrieve record by a number
     * @param int $id
     * @return mixed | Model
     */
    public function getByNumber($number)
    {
        return $this->getAll()->where('number', $number)->first();
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
     * @return AirtableModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        $collection = AirtableModel::all();
        return $collection;
    }

    /**
     * Delete a specific resource
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return AirtableModel::destroy($id);
    }
}
