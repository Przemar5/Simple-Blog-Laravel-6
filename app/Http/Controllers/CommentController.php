<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Comment validation rules for checking request
    private $validationRules = [
        'author' => [
            'required',
            'max:255',
            'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() \+\/\*]+$/'
        ],
        'email' => [
            'required',
            'max:255',
            'email',
            'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() \@]+$/'
        ],
        'comment' => [
            'required',
            'between:5,2000',
            'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,()\"\ \:\;\+\=\/\#\<\>@\[\]\{\}\-\`\+\#]+$/'
        ],
        'post_id' => [
            'max:255',
            'numeric'
        ]
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'verified'
        ])->except([
            'store'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules);

        $post_id = $request->input('post_id');
        $post = Post::find($post_id);

        $comment = new Comment();
        $comment->author = $request->input('author');
        $comment->email = $request->input('email');
        $comment->comment = $request->input('comment');
        $comment->approved = true;
        $comment->post()->associate($post);
        $comment->save();

        return redirect()->route('posts.show', $post->slug)->with('success', 'Your comment have been added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::find($id);

        return view('comments.edit')->with('comment', $comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if(!empty($comment)) {
            $this->validate($request, $this->validationRules);

            $comment->author = $request->input('author');
            $comment->email = $request->input('email');
            $comment->comment = $request->input('comment');
            $comment->save();

            return redirect()->route('posts.show', ['slug' => $comment->post->slug])->with('success', 'Comment updated.');

        } else {
            return redirect()->route('posts.index')->with('error', "Given comment's post doesn't exist.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $post_slug = $comment->post->slug;

        $comment->delete();

        return redirect()->route('posts.show', ['slug' => $post_slug])->with('success', 'Comment deleted successfully');
    }
}
