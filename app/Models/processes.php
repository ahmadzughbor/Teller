<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class processes extends Model
{
    use HasFactory;
    protected $table = "processes";
    protected $fillable = [
        'wallet_id',
        'balance_before',
        'balance_after',
        'amount_before',
        'amount_after',
        'tax_value',
    ];



    public function wallet()
    {
        return $this->belongsTo(wallet::class, 'wallet_id');
    }


    public function scopeFilterByUserName(Builder $query, string $name)
    {
        return $query->whereHas('wallet', function ($query) use ($name) {
            $query->whereHas('user', function ($query) use ($name) {
                $query->where('name','LIKE' ,"%" . $name ."%" );
            });
        });
    }
    public function scopeFiltedatefrom(Builder $query, string $date)
    {
        return $query->where('created_at', ">=", $date);
    }
    public function scopeFiltedateto(Builder $query, string $date)
    {
        return $query->where('created_at', "<=", $date);
    }
    public function scopeFiltedateAmount(Builder $query, string $date, $type)
    {
        return $query->where('amount_after',$type, $date);
    }
}
