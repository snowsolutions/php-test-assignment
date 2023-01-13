<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class ResourceOwnership
{
    /**
     * Verify if the request resource is authorize
     *
     * @param $resource
     * @param $ownerId
     * @param $ownerIdRefField
     * @return bool
     * @throws \Exception
     */
    public static function authorize($resource, $resourceRefFieldName = 'id', $userId = null)
    {
        try {
            $loggedUser = Auth::user();
            if (!$userId) {
                $userId = $loggedUser->getAuthIdentifier();
            }
            if (is_array($resource)) {
                return $resource[$resourceRefFieldName] == $userId;
            } else {
                return $resource->$resourceRefFieldName == $userId;
            }
        } catch (\Exception $exception) {
            throw new \Exception(__('Authorize error. You do not have access to this resource'));
        }
    }
}
