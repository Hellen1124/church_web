<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksUserActions;

class Tenant extends Model
{
    use HasFactory, SoftDeletes, TracksUserActions;

    protected $fillable = [
        'user_id',
        'church_name',
        'church_mobile',
        'church_email',
        'address',
        'logo_image',
        'location',
        'website',
        'vat_pin',
        'kra_pin',
        'domain',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['logo'];

  

    /**
     * 👤 The owner of this tenant.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 👥 All users belonging to this tenant.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * 🧍 Creator (user who created this tenant)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * 🧍‍♂️ Updater (user who last updated this tenant)
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * 🖼️ Compute logo URL dynamically
     */
    public function getLogoAttribute()
    {
        if ($this->logo_image) {
            return "https://" . $this->domain . "/storage/" . Str::slug($this->church_name) . "/logo/{$this->logo_image}";
        }

        return config('app.url') . "/assets/images/Afrinet.png";
    }

    public function members()
{
    return $this->hasMany(\App\Models\Member::class, 'tenant_id');
}

public function offerings()
    {
        return $this->hasMany(\App\Models\Offering::class, 'tenant_id');
    }

    public function events()
    {
        return $this->hasMany(\App\Models\Event::class, 'tenant_id');
    }

    public function sundayCollections()
    {
        return $this->hasMany(SundayCollection::class);
    }
}
