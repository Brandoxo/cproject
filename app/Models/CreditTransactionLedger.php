<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditTransactionLedger extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'credit_transactions_ledger';

    protected $fillable = [
        'transaction_id',
        'external_account_id',
        'balance_after_transaction',
        'transaction_type',
        'payment_id',
        'service_line_id',
        'admin_adjustment_reason',
    ];

    protected $casts = [
        'balance_after_transaction' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::updating(fn () => throw new \DomainException('Ledger is append-only'));
        static::deleting(fn () => throw new \DomainException('Ledger is append-only'));
    }

    public function account()
    {
        return $this->belongsTo(ExternalAccount::class, 'external_account_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function serviceLine()
    {
        return $this->belongsTo(ServiceLine::class, 'service_line_id');
    }
}
