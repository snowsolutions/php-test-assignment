<?php

namespace App\Http\Controllers;

use App\Helpers\ResourceOwnership;
use App\Helpers\RoleAuthorize;
use App\Repositories\Site\SiteRepository;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitesController extends Controller
{
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
        SiteRepository $siteRepository
    )
    {
        $this->middleware('auth');
        $this->siteRepository = $siteRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * Group 1 - Task 1: Modify SitesController@index endpoint to display all sites to admin.
         */
        $user = auth()->user();
        if (RoleAuthorize::isAdmin()) {
            $sites = Site::all();
        } else {
            $sites = $user->sites()->get();
        }

        return view('sites.index', [
            'sites' => $sites,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $randomVesselNames = [
            'The Blankney',
            'Beaver',
            'Quainton',
            'Churchill',
            'Thatcham',
            'Cowper',
            'Adelaide',
            'The Kildimo',
            'Infanta',
        ];

        return view('sites.create', [
            'namePlaceholder' => '"' . $randomVesselNames[array_rand($randomVesselNames)] . '"',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $siteData = [
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            /**
             * Group 2 - Task 4: Implement a form to submit API credentials for a site.
             */
            'airtable_access_key' => $request->input('airtable_access_key'),
            'airtable_base_id' => $request->input('airtable_base_id'),
            'user_id' => auth()->user()->id,
        ];
        $this->siteRepository->create($siteData);

        return redirect()->route('sites.index');
    }

    /**
     * Group 1 - Task 2: Implement SiteController@show endpoint
     * The endpoint should output information on a site, stored in database.
     * You need to create a basic view, controller method
     * Display a resource information
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $site = $this->siteRepository->get($id);
        if (!ResourceOwnership::authorize($site, 'user_id') && !RoleAuthorize::isAdmin()) {
            return abort(401);
        }
        return view('sites.view', [
            'site' => $this->siteRepository->get($id)
        ]);
    }

    /**
     * Group 1 - Task 3
     * Create endpoints and button in UI that takes data from sites table and generates CSV file to download.
     * CSV file should include name and email of user whom a site belongs to
     *
     * Export CSV file
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            , 'Content-type' => 'text/csv'
            , 'Content-Disposition' => 'attachment; filename=sites.csv'
            , 'Expires' => '0'
            , 'Pragma' => 'public'
        ];

        $loggedUser = auth()->user();
        if (RoleAuthorize::isAdmin()) {
            $collection = $this->siteRepository->getAll();
        } else {
            $collection = $this->siteRepository->getByUserId($loggedUser->getAuthIdentifier());
        }
        $csvData = [];
        foreach ($collection as $site) {
            $csvData[] = [
                'id' => $site->id,
                'name' => $site->name,
                'type' => $site->type,
                'user_id' => $site->user_id,
                'user_name' => $site->user->name,
                'user_email' => $site->user->email,
                'created_at' => $site->created_at,
                'updated_at' => $site->updated_at,
            ];
        }
        $csvHeader = [
            'ID',
            'Name',
            'Type',
            'User ID',
            'User Name',
            'User Email',
            'Created At',
            'Updated At',
        ];
        $callback = function () use ($csvData, $csvHeader) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);
            foreach ($csvData as $rowData) {

                fputcsv($file, $rowData);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
