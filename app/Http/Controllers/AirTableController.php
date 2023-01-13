<?php

namespace App\Http\Controllers;

use App\Helpers\AirTableTree;
use App\Repositories\Site\SiteRepository;
use App\Services\AirTable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AirTableController extends Controller
{
    /**
     * @var AirTable
     */
    protected $airTable;

    /**
     * @var SiteRepository
     */
    protected $siteRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        AirTable       $airTable,
        SiteRepository $siteRepository
    )
    {
        $this->middleware('auth');
        $this->airTable = $airTable;
        $this->siteRepository = $siteRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        /**
         * Group 2 - Task 4: Implement a Controller/View that fetches data from models table in Airtable and outputs models in a tree-like structure. References in children and parent are stored in model_model pivot.
         */
        $site = $this->siteRepository->get($id);
        $token = $site->airtable_access_key;
        $baseId = $site->airtable_base_id;
        $this->airTable->getConnection();
        $this->airTable->setConnectionToken($token);
        $this->airTable->setConnectionBaseId($baseId);
        $modelData = $this->airTable->getAllRecords(AirTable::AIRTABLE_TABLE_MODEL_ID);
        $this->airTable->resetAllRecords();
        $modelModelData = $this->airTable->getAllRecords(AirTable::AIRTABLE_TABLE_MODEL_MODEL_ID);
        $this->airTable->resetAllRecords();
        $treeData = AirTableTree::populateTreeData($modelData, $modelModelData);

        return view('airtable.index', [
            'treeData' => $treeData,
        ]);
    }
}
