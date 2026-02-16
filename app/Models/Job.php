<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
protected $fillable = [
    'client_id',
    'trade_id',
    'title',
    'description',
    'budget',
    'location',
    'status'
];


public function trade()
{
    return $this->belongsTo(Trade::class);
}


}
