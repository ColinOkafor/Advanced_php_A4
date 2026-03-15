<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateBlog($id)
    {
        $blog = Blog::find($id);
        $blog->status = "All good";
        $blog->save();

        return $this->showBlogs();
    }    
    public function deleteBlog($id)
    {
        $blog = Blog::find($id);
        $blog->delete();

        return $this->showBlogs();
    }   

}
 