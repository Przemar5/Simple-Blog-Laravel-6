@extends('layouts.app')

@section('title', ' | Dashboard')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            <h2 class="text-center">{{  $data['title']  }}</h2>

            <div class="d-flex justify-content-between w-100 ">
                <h3>Your Blog Posts</h3>
                <a href="{{  route('posts.create')  }}" class="btn btn-primary">Create Post</a>
            </div>

            @if(count($data['posts']))
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Url</th>
                                <th>Category</th>
                                <th>Body</th>
                                <th>Created at</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($data['posts'] as $post)
                            <tr>
                                <td>{{  $post->id  }}</td>
                                <td>
                                    <a href="{{  route('posts.show', $post->slug)  }}">
                                        {{  Str::limit(strip_tags($post->title), $limit = 20, $end = '...')  }}</td>
                                    </a>
                                <td>{{  Str::limit(strip_tags($post->slug), $limit = 20, $end = '...')  }}</td>
                                <td>{{  Str::limit(strip_tags($post->category['name']), $limit = 20, $end = '...')  }}</td>
                                <td>{!! Str::limit(strip_tags($post->body), $limit = 20, $end = '...') !!}</td>
                                <td>{{  date('M j, Y', strtotime($post->created_at))  }}</td>
                                <td class="text-right admin-table-buttons">
                                    <a href="{{  route('posts.edit', $post->slug)  }}" class="btn btn-default btn-sm btn-edit d-inline">Edit</a>
                                    {!! Form::open([
                                        'action' => ['PostController@destroy', $post->slug],
                                        'method' => 'POST'
                                    ]) !!}
                                        {{  Form::hidden('_method', 'DELETE')  }}
                                        {{  Form::submit('Delete', [
                                            'class' => 'btn btn-danger btn-sm d-inline'
                                        ])  }}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{  $data['posts']->links()  }}
            @else
                <h4>You have no posts</h4>
            @endif
        </div>
    </div>
</div>
@endsection
