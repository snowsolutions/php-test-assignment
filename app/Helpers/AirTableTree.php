<?php

namespace App\Helpers;

class AirTableTree
{
    /**
     * Group 2 - Task 4: Implement a Controller/View that fetches data from models table in Airtable and outputs models in a tree-like structure. References in children and parent are stored in model_model pivot.
     * @param $modelData
     * @param $modelModelData
     * @return array
     */
    public static function populateTreeData($modelData, $modelModelData)
    {
        $treeData = [];
        foreach ($modelData as $id => $modelDataRow) {
            $treeRowData = [
                'id' => $id,
                'number' => $modelDataRow['number'],
                'description' => $modelDataRow['description'],
                'unit' => $modelDataRow['unit'],
            ];
            if (array_key_exists('children', $modelDataRow)) {
                $treeRowData['children'] = [];
                foreach ($modelDataRow['children'] as $childId) {
                    $childData = $modelModelData[$childId];
                    $treeRowData['children'][] = $childData;
                }
            }
            $treeData[] = $treeRowData;
        }
        return $treeData;
    }
}
