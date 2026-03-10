<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'job_id',
        'worker_id',
        'worker_name',
        'reason',
        'subject',
        'description',
        'screenshot',
        'status',
        'admin_notes',
    ];

  
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

   
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    public function getReasonLabelAttribute(): string
    {
        return match ($this->reason) {
            'no_show'         => 'Worker did not show up',
            'incomplete_work' => 'Incomplete or poor quality work',
            'unprofessional'  => 'Unprofessional behavior',
            'overcharging'    => 'Overcharging / unauthorized fees',
            'damage'          => 'Damage to property',
            default           => 'Other',
        };
    }


    public function getScreenshotUrlAttribute(): ?string
    {
        return $this->screenshot
            ? asset('storage/' . $this->screenshot)
            : null;
    }


    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}