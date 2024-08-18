<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{   
    protected $table = 'Task';
    protected $fillable = [
        'id',
        'user_id',
        'task_title',
        'description',
        'date',
        'deadline',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
