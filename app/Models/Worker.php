<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable = ['user_id','phone','trade_id','experience_years'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trade()
{
    return $this->belongsTo(Trade::class);
}
    
}

