<?php


namespace App\Models;
use App\traits\TracksUserActions;

use Illuminate\Database\Eloquent\Model;

class Offering extends Model
{

    use TracksUserActions;
    
    protected $fillable = [
        'tenant_id',
        'amount',
        'type',
        'payment_method',
        'notes',
        'recorded_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'recorded_at' => 'datetime',
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
