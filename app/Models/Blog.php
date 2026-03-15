<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    // Point this model to the exact table name from your migration
    protected $table = 'blog_articles'; 

    // Allow these fields to be saved to the database
    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}