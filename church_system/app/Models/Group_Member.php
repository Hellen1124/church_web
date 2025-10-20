<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group_Member extends Model
{
     protected $table = 'group_member';
    public $incrementing = true;

    protected $fillable = [
        'group_id',
        'member_id',
        'role',
        'joined_at',
        'left_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];
}
