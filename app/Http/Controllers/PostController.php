<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use Mews\Purifier\Facades\Purifier;

class PostController extends Controller
{
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
            'index',
            'show'
        ]);
    }

    /**
     * Get validation rules.
     *
     * @param string $id
     * @return array
     */
    private function getValidationRules($id = '')
    {
        return [
            'title' => [
                'required',
                'unique:posts,title,'.$id,
                'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() \-\"\+\#]+$/',
                'max:255',
            ],
            'slug' => [
                'required',
                'unique:posts,slug,'.$id,
                'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() \:\;\+\=\/\#\<\>@\[\]\{\}\-\`\+\#]+$/',
                'between:5,255'
            ],
            'category_id' => [
                'required',
                'integer',
                'max:255'
            ],
            'body' => [
                'required',
                //'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,()\"\ \&\|\^\*\:\;\+\=\/\#\<\>@\[\]\{\}\-\`\+\#]+$/'
            ],
            'cover_image' => [
                'image',
                'sometimes',
                'max:1999'
            ]
        ];
    }

    /**
     * Store uploaded file.
     *
     * @param File $file
     * @return string $storedFileName
     */
    private function storeFile($file)
    {
        // Get filename with the extension
        $fileNameWithExt = $file->getClientOriginalName();

        // Get just filename
        $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

        // Get just extension
        $extension = $file->getClientOriginalExtension();

        // Filename to store
        $storedFileName = $filename . '_' . time() . '.' . $extension;

        // Upload Image
        $file->storeAs('public/cover_images', $storedFileName);

        return $storedFileName;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriesTmp = Category::all();
        $tagsTmp = Tag::all();
        $categories = [];
        $tags = [];

        foreach($categoriesTmp as $category) {
            $categories[$category->id] = $category->name;
        }

        foreach($tagsTmp as $tag) {
            $tags[$tag->id] = $tag->name;
        }

        $data = [
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('posts.create')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->getValidationRules());

        // Handle File Upload
        if ($request->hasFile('cover_image')) {
            $storedFileName = $this->storeFile($request->file('cover_image'));
        } else {
            $storedFileName = 'noimage.png';
        }

        // Create Post
        $post = new Post();
        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body = Purifier::clean($request->input('body'));
        $post->user_id = auth()->user()->id;
        $post->cover_image = $storedFileName;
        $post->save();

        $post->tags()->sync($request->input('tags'), false);

        return redirect()->route('posts.index')->with('success', 'Post created');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', '=', $slug)->first();

        if(isset($post)) {
            return view('posts.show')->with('post', $post);
        }

        return view('posts.index')->with('error', 'Post doesn\'t exist');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug', '=', $slug)->first();
        $categoriesTmp = Category::all();
        $categories = [];
        $tagsTmp = Tag::all();
        $tags = [];

        // Check for correct user
        if (auth()->user()->id !== $post->user_id) {
            return view('posts.index')->with('error', 'Unauthorized Page');
        }

        foreach($categoriesTmp as $category) {
            $categories[$category->id] = $category->name;
        }

        foreach($tagsTmp as $tag) {
            $tags[$tag->id] = $tag->name;
        }

        $data = [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('posts.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $post = Post::where('slug', '=', $slug)->first();

        if(!empty($post)) {
            $this->validate($request, $this->getValidationRules($post->id));

            $post->title = $request->input('title');
            $post->slug = $request->input('slug');
            $post->category_id = $request->input('category_id');
            $post->body = Purifier::clean($request->input('body'));

            // Handle File Upload
            if ($request->hasFile('cover_image')) {
                $post->cover_image = $this->storeFile($request->file('cover_image'));
            }

            $post->save();

            if(!empty($request->input('tags'))) {
                $post->tags()->sync($request->input('tags'));
            }
            else {
                $post->tags()->sync([]);
            }

            return redirect()->route('posts.index')->with('success', 'Post updated');
        }
        else {
            return redirect()->route('posts.index')->with('error', 'Something gone wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = Post::where('slug', '=', $slug)->first();
        $post->tags()->detach();

        // Check for correct user
        if(auth()->user()->id !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized Page');
        }

        $post->delete();

        if($post->cover_image != 'noimage.png') {
            // Delete Image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        return redirect()->route('posts.index')->with('success', 'Post Removed');
    }
}
