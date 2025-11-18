<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait TracksUserActions
{
    /**
     * Boot the trait and register model event hooks.
     */
    protected static function bootTracksUserActions()
    {
        static::creating(function ($model) {
            if (Auth::check() && empty($model->created_by)) {
                $model->created_by = Auth::user()->getKey();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::user()->getKey();
            }
        });
    }

    /**
     * Creator relationship (the user who created the record).
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * Updater relationship (the user who last updated the record).
     */
    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
