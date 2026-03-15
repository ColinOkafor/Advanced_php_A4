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
        $blogs = Blog::with('user')->orderBy('created_at', 'asc')->get();
        return view('blog', compact('blogs'));
    }

    // 2. Load the Manage Page
    public function manage()
    {
        $userBlogs = Auth::user()->blogs()->orderBy('created_at', 'asc')->get();
        return view('manage', compact('userBlogs'));
    }

    // 3. Handle Both Publish and Save Actions from the Manage Form
    public function processForm(Request $request)
    {
        // Action: PUBLISH
        if ($request->input('action') === 'publish') {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required'
            ]);

            Auth::user()->blogs()->create([
                'title' => $request->title,
                'content' => $request->content,
            ]);

            return redirect('/manage');
        }

        // Action: SAVE (Snapshot)
        if ($request->input('action') === 'save') {
            $snapshots = $request->session()->get('snapshots', []);
            $id = uniqid();
            
            $snapshots[$id] = [
                'title' => $request->input('title', ''),
                'content' => $request->input('content', ''),
                'time' => now()->format('Y-m-d g:ia') 
            ];

            $request->session()->put('snapshots', $snapshots);

            return redirect('/manage');
        }

        return redirect('/manage');
    }

    // 4. Delete a Published Article
    public function delete($id)
    {
        $blog = Blog::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $blog->delete();

        return redirect('/manage');
    }

    // 5. Load a Snapshot into Inputs
    public function loadSnapshot(Request $request, $id)
    {
        $snapshots = $request->session()->get('snapshots', []);

        if (isset($snapshots[$id])) {
            $request->session()->flash('draftTitle', $snapshots[$id]['title']);
            $request->session()->flash('draftContent', $snapshots[$id]['content']);
        }

        return redirect('/manage');
    }

    // 6. Delete a Snapshot from Session
    public function deleteSnapshot(Request $request, $id)
    {
        $snapshots = $request->session()->get('snapshots', []);

        if (isset($snapshots[$id])) {
            unset($snapshots[$id]);
            $request->session()->put('snapshots', $snapshots);
        }

        return redirect('/manage');
    }
}