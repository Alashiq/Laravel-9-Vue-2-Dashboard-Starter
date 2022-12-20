<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'permissions',
    ];

    public function admins()
    {
       return $this->hasMany(Admin::class,'role_id');
    }
}
