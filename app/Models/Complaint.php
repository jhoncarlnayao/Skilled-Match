<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'client_id',
        'worker_id',
        'fullname',
        'filed_by',
        'reason',
        'subject',
        'description',
        'screenshot',
        'status',
        'admin_notes',
    ];

    // ── RELATIONSHIPS ─────────────────────────────────────────────────

    /** The client user (filer when filed_by = 'client') */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /** The worker (filer when filed_by = 'worker') */
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    // ── ACCESSORS ─────────────────────────────────────────────────────

    /** Human-readable reason */
    public function getReasonLabelAttribute(): string
    {
        return match ($this->reason) {
            // Client-filed reasons
            'no_show'          => 'Worker did not show up',
            'incomplete_work'  => 'Incomplete / poor quality work',
            'unprofessional'   => 'Unprofessional behavior',
            'overcharging'     => 'Overcharging / unauthorized fees',
            'damage'           => 'Damage to property',
            // Worker-filed reasons
            'non_payment'      => 'Non-payment / underpayment',
            'false_info'       => 'False job information',
            'harassment'       => 'Harassment or abuse',
            'unsafe_condition' => 'Unsafe working conditions',
            'scope_creep'      => 'Excessive scope creep',
            default            => 'Other',
        };
    }

    /** Full storage URL for the screenshot */
    public function getScreenshotUrlAttribute(): ?string
    {
        return $this->screenshot
            ? asset('storage/' . $this->screenshot)
            : null;
    }

    // ── HELPERS ───────────────────────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}