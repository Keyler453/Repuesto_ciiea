<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'images',
        'videos',
        'documents',
        'comments',
        'likes',
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'documents' => 'array',
        'comments' => 'array',
    ];
}
