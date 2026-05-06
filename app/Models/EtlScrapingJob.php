<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtlScrapingJob extends Model
{
    protected $table = 'etl_scraping_jobs';

    protected $fillable = [
        'external_panel_id',
        'external_account_id',
        'job_type',
        'target',
        'status',
        'raw_payload',
        'clean_payload',
        'started_at',
        'finished_at',
        'error_message',
        'attempts',
    ];

    protected $casts = [
        'raw_payload'   => 'array',
        'clean_payload' => 'array',
        'started_at'    => 'datetime',
        'finished_at'   => 'datetime',
    ];

    public function panel()
    {
        return $this->belongsTo(ExternalPanel::class, 'external_panel_id');
    }

    public function account()
    {
        return $this->belongsTo(ExternalAccount::class, 'external_account_id');
    }
}
