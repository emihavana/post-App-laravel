<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller

{
    //function to delete a specific post
    public function deletePost(Post $post)
    {
        //check if the authenticated user is the owner of the post
        if (auth()->id() === $post->user_id) {
            $post->delete();
        }
        return redirect('/');
    }
    //function to update a specific post

    public function updatePost(Request $request, Post $post)
    {
        //validate the input data
        $validatedData = $request->validate([
            'title' => 'required|string|max:50',
            'content' => 'required|string|max:500',
        ]);

        //sanitize the input data to prevent XSS attacks
        $validatedData['title'] = strip_tags($validatedData['title']);
        $validatedData['content'] = strip_tags($validatedData['content']);

        //update the post with the validated and sanitized data
        $post->update($validatedData);

        return redirect('/');
    }
    //function to show the edit screen for a specific post
    public function showEditScreen(Post $post)
    {
        //check if the authenticated user is the owner of the post
        if (auth()->id() != $post->user_id) {
            return redirect('/');
        }

        return view('edit-post', ['post' => $post]);
    }
    //function to create a new post
    public function CreatePost(Request $request)
    {
        //validate the input data
        $validatedData = $request->validate([
            'title' => 'required|string|max:50',
            'content' => 'required|string|max:500',

        ]);
        //sanitize the input data to prevent XSS attacks
        $validatedData['title'] = strip_tags($validatedData['title']);
        $validatedData['content'] = strip_tags($validatedData['content']);
        $validatedData['user_id'] = auth()->id();

        Post::create($validatedData);

        return redirect('/');
    }
}
