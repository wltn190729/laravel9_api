<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'context'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
