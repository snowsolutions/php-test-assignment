<?php

namespace App\Repositories\Site;

use App\Site;
use Illuminate\Database\Eloquent\Model;

class SiteRepository
{

    /**
     * Create resource with provided data
     * @param $data
     * @return Site
     */
    public function create($data)
    {
        $object = new Site();
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
     * @return Site[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        $collection = Site::all();
        return $collection;
    }

    /**
     * Retrieve a colletion of model base on user_id
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserId($userId) {
        return $this->getAll()->where('user_id', $userId);
    }
}
