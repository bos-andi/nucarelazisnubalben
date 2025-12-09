<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'group',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions');
    }

    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }
}
