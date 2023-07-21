<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'title', 'description', 'deadline', 'owner_id'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('is_active', 'is_notified');
    }

}
