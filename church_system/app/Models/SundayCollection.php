<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;
use App\Traits\TracksUserActions;

class SundayCollection extends Model
{
    use HasFactory, BelongsToTenant, TracksUserActions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'collection_date',
        'first_service_amount',
        'second_service_amount',
        'children_service_amount',
        'mobile_mpesa_amount',
        'total_amount',
        'counted_by',
        'verified_by',
        'verified_by_2',
        'bank_deposit_amount',
        'bank_deposit_date',
        'bank_slip_number',
        'status',
        'notes',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'collection_date' => 'date',
        'first_service_amount' => 'decimal:2',
        'second_service_amount' => 'decimal:2',
        'children_service_amount' => 'decimal:2',
        'mobile_mpesa_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'bank_deposit_amount' => 'decimal:2',
        'bank_deposit_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Default attribute values
     */
    protected $attributes = [
        'first_service_amount' => 0,
        'second_service_amount' => 0,
        'children_service_amount' => 0,
        'mobile_mpesa_amount' => 0,
        'total_amount' => 0,
        'bank_deposit_amount' => 0,
        'status' => 'pending',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_COUNTED = 'counted';
    const STATUS_VERIFIED = 'verified';
    const STATUS_BANKED = 'banked';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Scopes for common queries
     */
    
    // Scope for current tenant is handled by BelongsToTenant trait
    
    // Scope for specific status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    
    public function scopePending($query)
    {
        return $query->status(self::STATUS_PENDING);
    }
    
    public function scopeCounted($query)
    {
        return $query->status(self::STATUS_COUNTED);
    }
    
    public function scopeVerified($query)
    {
        return $query->status(self::STATUS_VERIFIED);
    }
    
    public function scopeBanked($query)
    {
        return $query->status(self::STATUS_BANKED);
    }
    
    public function scopeCancelled($query)
    {
        return $query->status(self::STATUS_CANCELLED);
    }
    
    // Scope for date ranges
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('collection_date', $date);
    }
    
    // NEW: This month scope
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('collection_date', now()->month)
                    ->whereYear('collection_date', now()->year);
    }
    
    // NEW: Last month scope  
    public function scopeLastMonth($query)
    {
        return $query->whereMonth('collection_date', now()->subMonth()->month)
                    ->whereYear('collection_date', now()->subMonth()->year);
    }
    
    // NEW: Specific month and year
    public function scopeForMonthYear($query, $month, $year)
    {
        return $query->whereMonth('collection_date', $month)
                    ->whereYear('collection_date', $year);
    }
    
    // Scope for unreconciled collections
    public function scopeNotBanked($query)
    {
        return $query->where('status', '!=', self::STATUS_BANKED)
                    ->where('status', '!=', self::STATUS_CANCELLED);
    }
    
    // NEW: For current week
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('collection_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }
    
    // NEW: For specific year
    public function scopeForYear($query, $year)
    {
        return $query->whereYear('collection_date', $year);
    }

    /**
     * Relationships
     */
    
    // Mpesa transactions for this Sunday
    public function mpesaTransactions()
    {
        return $this->hasMany(MpesaTransaction::class, 'sunday_date', 'collection_date');
    }
    
    // Tenant relationship is handled by BelongsToTenant trait
    
    // Creator/updater relationships are handled by TracksUserActions trait
    
    // First verifier relationship
    public function firstVerifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    
    // Second verifier relationship
    public function secondVerifier()
    {
        return $this->belongsTo(User::class, 'verified_by_2');
    }
}