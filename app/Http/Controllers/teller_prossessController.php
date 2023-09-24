<?php

namespace App\Http\Controllers;

use App\Exports\processessExport;
use App\Models\processes;
use App\Models\User;
use App\Repositories\teller_processessRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class teller_prossessController extends Controller
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
        return view('admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function getUsers(Request $request)
    {
        $data =  $this->teller_processessRepository->getUsers($request->all());
        return $data;
    }
    public function data(Request $request)
    {
        $data =  $this->teller_processessRepository->dataTable($request->all());
        return DataTables::of($data->items())
            ->addIndexColumn()
            ->addColumn('user', function ($row) {
                return $row->wallet->user->name;
            })
            ->addColumn('wallet_id', function ($row) {
                return $row->wallet_id;
            })
            ->addColumn('balance_before', function ($row) {
                return $row->balance_before;
            })
            ->addColumn('balance_after', function ($row) {
                return $row->balance_after;
            })
            ->addColumn('amount_before', function ($row) {
                return $row->amount_before;
            })
            ->addColumn('amount_after', function ($row) {
                return $row->amount_after;
            })
            ->addColumn('tax_value', function ($row) {
                return $row->tax_value;
            })
            ->addColumn('date', function ($row) {
                return $row->created_at;
            })
            
            ->rawColumns([])->toJson();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'userSelect' => 'required',
            'amount' => 'required|numeric',
            'tax_value' => 'required|numeric|min:1.5|max:100',
        ]);
        try {

            $data =  $this->teller_processessRepository->store($request->all());
            return $data;
        } catch (Exception $e) {

            return response()->json($e->getMessage(), 500);
        }

        
        // DB::transaction(function () use($request){
        // $user = User::where('role',1)->with('wallet')->get();
        // $client  = User::where('id',$request->userSelect)->with('wallet')->get();
        // $userwallet = $user->wallet;
        // $wallet = $client->wallet;
        // $amount_before = $request->amount;
        // $amount_after  = $request->amount - ( $request->amount *  $request->tax_value / 100   );
        // $balance_before = $client->wallet->balance;
        // $balance_after = $client->wallet->balance + $amount_after ;
        // $tax_value =  $request->tax_value;

        //     $userwallet->update([
        //         'balance' => $userwallet->balance -  $amount_after 
        //     ]);
        //     $wallet->update([
        //         'balance' => $wallet->balance +  $amount_after 
        //     ]);
            
            
            
        //     $processes = processes::create([
        //         'wallet_id' =>  $wallet->id,
        //         'balance_before' =>   $balance_before ,
        //         'balance_after' =>   $balance_after ,
        //         'amount_before' =>   $amount_before ,
        //         'amount_after' =>   $amount_after ,
        //         'tax_value' =>   $tax_value ,
        //     ]);
            
        // });



    }
    public function processessExport(Request $request)
    {
        $request->validate([
            'nameFillter' => 'nullable',
            'FromDateFillter' => 'nullable',
            'toDateFillter' => 'nullable',
            'amountFilter' => 'nullable',
            'amountTypeFilter' => 'nullable',
        ]);
        
        $data =  $this->teller_processessRepository->dataTable($request->all());
        // dd($data);
        return Excel::download(new processessExport($data) , 'processessExport.xlsx');

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
