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

    // ============================================================
    // USER
    // ============================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }

    // ============================================================
    // VALIDASI MEMBER
    // ============================================================

    /**
     * Menentukan apakah barcode/member masih valid.
     *
     * Member valid jika:
     * - is_active = true
     * - sudah memasuki valid_from jika diisi
     * - belum melewati valid_until jika diisi
     */
    public function isValid(): bool
    {
        // --------------------------------------------------------
        // MEMBER TIDAK AKTIF
        // --------------------------------------------------------

        if (!$this->is_active) {
            return false;
        }

        // --------------------------------------------------------
        // BELUM MASUK MASA BERLAKU
        // --------------------------------------------------------

        if (
            $this->valid_from !== null &&
            now()->isBefore($this->valid_from)
        ) {
            return false;
        }

        // --------------------------------------------------------
        // SUDAH KADALUARSA
        // --------------------------------------------------------

        if (
            $this->valid_until !== null &&
            now()->isAfter($this->valid_until)
        ) {
            return false;
        }

        // --------------------------------------------------------
        // VALID
        // --------------------------------------------------------

        return true;
    }

    // ============================================================
    // MYSTERY BOX
    // ============================================================

    /**
     * Apakah member sudah mendapatkan Mystery Box?
     */
    public function hasMysteryReward(): bool
    {
        return $this->stamp_count >= $this->stamp_target;
    }

    // ============================================================
    // STAMP TRANSACTIONS
    // ============================================================

    public function stampTransactions(): HasMany
    {
        return $this->hasMany(
            StampTransaction::class
        );
    }
}
