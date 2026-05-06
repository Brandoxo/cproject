<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'package_id',
        'catalog_package_name',
        'service_line_id',
        'crm_customer_id',
        'customer_full_name_snapshot',
        'customer_email_snapshot',
        'customer_whatsapp_snapshot',
        'user_id',
        'amount_paid',
        'currency',
        'payment_method',
        'image_path',
        'transaction_id',
        'status',
        'payment_date',
    ];

    protected $casts = [
        'amount_paid'  => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(CrmCustomer::class, 'crm_customer_id');
    }

    public function serviceLine()
    {
        return $this->belongsTo(ServiceLine::class);
    }

    public function package()
    {
        return $this->belongsTo(CatalogPackage::class, 'package_id');
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ledgerEntries()
    {
        return $this->hasMany(CreditTransactionLedger::class, 'payment_id');
    }
}
