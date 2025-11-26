<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'description',
        'is_highlighted',
    ];

    protected $casts = [
        'is_highlighted' => 'boolean',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
