<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalPanel extends Model
{
    protected $cast = [
        'api_key' => 'encrypted',
    ];

}
