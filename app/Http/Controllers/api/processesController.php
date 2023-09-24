<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TellerProcessResourceCollection;
use App\Repositories\teller_processessRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class processesController extends Controller
{


    protected $teller_processessRepository;


    public function __construct(teller_processessRepository $teller_processessRepository)
    {
        $this->teller_processessRepository = $teller_processessRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function data(Request $request)
    {
        $data =  $this->teller_processessRepository->dataTable($request->all());
        
        return new TellerProcessResourceCollection($data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
