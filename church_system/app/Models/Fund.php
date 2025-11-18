<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TracksUserActions;

class Fund extends Model
{

    use TracksUserActions;
    
    protected $fillable = [
        'tenant_id',
        'name',
        'slug',
        'description',
        'active',
        'metadata',
    ];

    protected $casts = [
        'active'   => 'boolean',
        'metadata' => 'array',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

}
