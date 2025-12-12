<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use App\Traits\TracksUserActions;

class Expense extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant, TracksUserActions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'expense_date',
        'expense_number',
        'amount',
        'expense_category_id',
        'description',
        'paid_to',
        'payment_method',
        'reference_number',
        'approved_by',      // user_id of first approver (Treasurer)
        'approved_by_2',    // user_id of second committee member
        'approved_at',
        'receipt_available',
        'receipt_path',
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
        'expense_date' => 'date',
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'receipt_available' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Default attribute values
     */
    protected $attributes = [
        'amount' => 0,
        'receipt_available' => false,
        'status' => 'pending',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_PAID = 'paid';
    const STATUS_REJECTED = 'rejected';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Relationships
     */
    
    // Expense category
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
    
    // First approver (Treasurer)
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    // Second committee member
    public function secondApprover()
    {
        return $this->belongsTo(User::class, 'approved_by_2');
    }
    
    // In your Expense model, add these scopes:

public function scopeThisMonth($query)
{
    return $query->whereMonth('expense_date', now()->month)
                ->whereYear('expense_date', now()->year);
}

public function scopeLastMonth($query)
{
    return $query->whereMonth('expense_date', now()->subMonth()->month)
                ->whereYear('expense_date', now()->subMonth()->year);
}

public function scopePending($query)
{
    return $query->where('status', 'pending');
}

public function scopeApproved($query)
{
    return $query->where('status', 'approved');
}

public function scopePaid($query)
{
    return $query->where('status', 'paid');
}


/**
 * Scope for specific month and year
 */
public function scopeForMonthYear($query, $month, $year)
{
    // Use the expense_date field for filtering
    return $query->whereMonth('expense_date', $month)
                 ->whereYear('expense_date', $year);
}
    
    // Tenant relationship is handled by BelongsToTenant trait
    
    // Creator/updater relationships are handled by TracksUserActions trait
}
