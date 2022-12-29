<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'permissions',
        'state',
    ];

    public function admins()
    {
       return $this->hasMany(Admin::class,'role_id')->where('admins.state', '<>', 9);
    }
}
