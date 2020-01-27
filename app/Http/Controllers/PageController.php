<?php

namespace App\Http\Controllers;

use App\Post;

class PageController extends Controller
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
        ])->only([
            'dashboard'
        ]);
    }

    /**
     * Display home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Welcome to MyBlog';

        return view('pages.index', compact('title'));
    }

    /**
     * Display a dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = auth()->user();
        $title = 'Welcome, '.$user->name;
        $posts = Post::where('user_id', '=', $user->id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(10);

        $data = [
            'title' => $title,
            'posts' => $posts
        ];

        return view('pages.dashboard', compact('data'));
    }

    /**
     * Display about page.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        $title = 'About Us';

        return view('pages.about', compact('title'));
    }

    /**
     * Display contact form.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        $data = [
            'title' => 'Contact',
        ];

        return view('pages.contact', compact('data'));
    }
}
