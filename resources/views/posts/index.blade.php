@extends('layouts.app')

@section('title', ' | Posts')

@section('content')
<div class="container">
    <h2>Posts</h2>

    @if(count($posts))
        @foreach($posts as $post)
            <div class="well p-1">
                <div class="row">
                    <div class="col-sm-4">
                        <img src="/storage/cover_images/{{  $post->cover_image  }}" alt="" class="d-block" style="width: 100%;">
                    </div>

                    <div class="col-sm-8">
                        <h3>
                            <small class="text-muted">Written on {{  date('M j, Y', strtotime($post->created_at))  }} by {{  $post->user->name ?? ''  }}</small>
                            <div>
                                <a href="{{  URL::route('posts.show', $post->slug)  }}">{{  $post->title  }}</a>
                            </div>
                        </h3>
                        <p>{!! \Illuminate\Support\Str::limit($post->body, $limit = 300, $end = '...') !!}</p>
                        {!! strlen($post->body) > 300 ? '<a href="'.URL::route('posts.show', $post->slug).'" class="text-primary d-block">Read More</a>' : '' !!}
                    </div>
                </div>
            </div>
        @endforeach
        {{  $posts->links()  }}
    @else
        <p>No posts found</p>
    @endif
</div>
@endsection
