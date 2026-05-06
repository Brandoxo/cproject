<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmCustomer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'whatsapp_number',
        'notes',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function serviceLines()
    {
        return $this->hasMany(ServiceLine::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notificationLogs()
    {
        return $this->hasMany(NotificationLog::class);
    }
}
