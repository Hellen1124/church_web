<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
     use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'amount',
        'currency',
        'payment_method',
        'reference',      // unique ref / transaction id
        'donor_name',
        'donor_contact',
        'notes',
        'received_at',
        'reconciled',
        'metadata',      // JSON field for additional data
       
    ];

    protected $casts = [
        'amount'      => 'decimal:2',
        'received_at' => 'datetime',
        'reconciled'  => 'boolean',
        'metadata'    => 'array',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
