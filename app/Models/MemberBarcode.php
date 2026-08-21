<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemberBarcode extends Model
{
    protected $fillable = [
        'user_id',
        'birth_date',
        'code',
        'discount_type',
        'discount_value',
        'stamp_count',
        'stamp_target',
        'is_active',
        'valid_from',
        'valid_until',
        'synced_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'discount_value' => 'decimal:2',

        'stamp_count' => 'integer',
        'stamp_target' => 'integer',

        'is_active' => 'boolean',

        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }

    /**
     * Apakah member sudah mendapatkan Mystery Box?
     */
    public function hasMysteryReward(): bool
    {
        return $this->stamp_count >= $this->stamp_target;
    }

    public function stampTransactions(): HasMany
    {
        return $this->hasMany(
            StampTransaction::class
        );
    }

}
