<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $table = 'notification_logs';

    protected $fillable = [
        'service_line_id',
        'crm_customer_id',
        'channel',
        'notification_type',
        'payload',
        'status',
        'sent_at',
        'error_message',
    ];

    protected $casts = [
        'payload' => 'array',
        'sent_at' => 'datetime',
    ];

    public function serviceLine()
    {
        return $this->belongsTo(ServiceLine::class);
    }

    public function customer()
    {
        return $this->belongsTo(CrmCustomer::class, 'crm_customer_id');
    }
}
