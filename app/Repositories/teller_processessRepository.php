<?php

namespace App\Repositories;

use App\Http\Requests\TestRequest;
use App\Models\processes;
use App\Models\Test;
use App\Models\User;
use App\Repositories\Interfaces\teller_processessInterface;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class teller_processessRepository implements teller_processessInterface

{
    private $processes;

    public function __construct(processes $processes)
    {
        $this->processes = $processes;
    }

    public function all()
    {
        // Implement the logic here...
    }

    public function dataTable(array $attributes)
    {
        
        $data = $this->processes->with('wallet.user');
        if(isset($attributes['nameFillter'])){
            $data->FilterByUserName($attributes['nameFillter']);
        }
        if(isset($attributes['FromDateFillter'])){
            $data->Filtedatefrom($attributes['FromDateFillter']);
        }
        if(isset($attributes['toDateFillter'])){
            $data->Filtedateto($attributes['toDateFillter']);
        }
        if(isset($attributes['AmountFillter'] )){
            $data->FiltedateAmount($attributes['AmountFillter'], $attributes['AmountTypeFillter']);
        }
        $data = $data->paginate();
        return $data ;
       
    }

    public function find($hashId)
    {
        return $this->processes->findOrFailByHash($hashId);
    }
    public function getUsers(array $attributes)
    {
        $users =  User::where('role', '!=' , 1)->orWhereNull('role')->where('name', "LIKE" , '%' .$attributes['q'] . '%')->limit(5)->get();
        return $users;
    }

    public function store(array $attributes)
    {
        return DB::select('CALL processTransaction2(?, ?, ?)', [$attributes['userSelect'], $attributes['amount'], $attributes['tax_value']]);
    }

   
}
