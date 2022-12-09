<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasFactory;
    use HasApiTokens;
    protected $fillable = [
        'phone',
        'first_name',
        'last_name',
        'password',
        'role_id',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    

    // public function role()
    // {
    //     return $this->belongsTo(related: Permission::class, foreignKey: 'role_id');
    // }

}
