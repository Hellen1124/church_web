<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
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
