<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends Model implements AuthenticatableContract
{

    use Authenticatable;
    
    protected $table = 'User';
    protected $fillable = [
        'id',
        'username',
        'password',
        'email',
        'role',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }
}
