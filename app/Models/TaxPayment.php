<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxPayment extends Model
{
    protected $fillable = [
        'period',
        'payment_date',
        'amount',
        'reference',
        'notes',
        'proof_path',
        'user_id',
    ];

    protected $casts = [
        'amount' => 'integer',
        'payment_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getProofUrlAttribute(): string
    {
        return asset('storage/' . $this->proof_path);
    }

    /** "2026-10" => "Oktober 2026" */
    public function getPeriodLabelAttribute(): string
    {
        return self::periodLabel($this->period);
    }

    public static function periodLabel(string $period): string
    {
        return \Carbon\Carbon::createFromFormat('Y-m', $period)
            ->locale('id')
            ->translatedFormat('F Y');
    }
}
