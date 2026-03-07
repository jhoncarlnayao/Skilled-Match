<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'client_id',
        'worker_id',      
        'trade_id',
        'title',
        'description',
        'budget',
        'location',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'budget'       => 'decimal:2',
    ];

    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function worker()
    {
        // Explicitly declare foreign key to be safe
        return $this->belongsTo(Worker::class, 'worker_id');
    }
}