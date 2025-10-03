<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Tenant extends AbstractModel
{
   
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
        'is_active'
    ];

    protected $appends = ['logo'];

      /**
     * Get the user that owns the Tenant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the users for the Tenant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getLogoAttribute()
    {
        if ($this->logo_image) {
            return "https://" . $this->domain . "/storage/" . Str::slug($this->name) . "/logo/{$this->logo_image}";
        }

        return config('app.url') . "/assets/images/Afrinet.png";
    }


}