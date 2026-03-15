<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    // 1. Load the Public Blog Page
    public function index()
    {
        // ELOQUENT: Fetch all blogs along with their author (user), ordered chronologically
        $blogs = Blog::with('user')->orderBy('created_at', 'asc')->get();
        
        return view('blog', compact('blogs'));
    }

    // 2. Load the Manage Page
    public function manage()
    {
        // ELOQUENT: Fetch ONLY the blogs that belong to the currently logged-in user
        $userBlogs = Auth::user()->blogs()->orderBy('created_at', 'asc')->get();
        
        return view('manage', compact('userBlogs'));
    }

    // 3. Publish a New Article
    public function publish(Request $request)
    {
        // Basic validation so we don't save empty posts
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required'
        ]);

        // ELOQUENT: Create a new blog post directly linked to the authenticated user.
        // Because we set up the relationship in the User model, Laravel automatically fills in the user_id.
        Auth::user()->blogs()->create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // Reload the page so the new article appears in the table
        return redirect('/manage');
    }

    // 4. Delete an Article
    public function delete($id)
    {
        // ELOQUENT: Find the specific blog by its ID, ensuring it belongs to the logged-in user
        $blog = Blog::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        // ELOQUENT: Delete the record from the database
        $blog->delete();

        // Reload the page so the deleted article disappears from the table
        return redirect('/manage');
    }
}