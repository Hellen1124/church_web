<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TracksUserActions;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens;
    use HasRoles;
    use SoftDeletes;
    use TracksUserActions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   protected $fillable = [
        'tenant_id', 
        'member_id',     
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'otp_token',
       'created_by',
       'updated_by',
    ];

   


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // USING EMAIL FOR VERIFICATION THOUGH LOGIN IS PHONE.
            'password' => 'hashed',
        ];
    }

    public function member() // RELATION TO MEMBER
{
    return $this->belongsTo(Member::class);

}

    public function tenant() // RELATION TO TENANT
    {
        return $this->belongsTo(Tenant::class);
    }

    public function getPermissionsAttribute() // GET ALL PERMISSIONS OF USER
    {
        return $this->roles->load('permissions')->pluck('permissions')->flatten()->pluck('name');
    }

    public function getAuthIdentifierName() // USE PHONE FOR AUTHENTICATION
{
    return 'phone';
}


}
