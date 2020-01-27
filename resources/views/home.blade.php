@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            <a href="/posts/create" class="btn btn-primary">Create Post</a>

            @if(count($posts) > 0)
                <h3>Your Blog Posts</h3>
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Url</th>
                        <th>Body</th>
                        <th>Created at</th>
                        <th></th>
                    </tr>
                    @foreach($posts as $post)
                        <tr>
                            <td>
                                <a href="/posts/{{  $post->id  }}">{{  $post->id  }}</a>
                            </td>
                            <td>{{  \Illuminate\Support\Str::limit($post->title, $limit = 20, $end = '...')  }}</td>
                            <td>{{  \Illuminate\Support\Str::limit($post->slug, $limit = 20, $end = '...')  }}</td>
                            <td>{{  \Illuminate\Support\Str::limit($post->body, $limit = 20, $end = '...')  }}</td>
                            <td>{{  date('M j, Y', strtotime($post->created_at))  }}</td>
                            <td class="d-inline d-inline-custom">
                                <a href="/posts/{{  $post->id  }}/edit" class="btn btn-default d-inline">Edit</a>
                                {!!  Form::open([
                                    'action' => ['PostController@destroy', $post->id],
                                    'method' => 'POST'
                                ])  !!}
                                    {{  Form::hidden('_method', 'DELETE')  }}
                                    {{  Form::submit('Delete', [
                                        'class' => 'btn btn-danger'
                                    ])  }}
                                {!!  Form::close()  !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <h4>You have no posts</h4>
            @endif
        </div>
    </div>
</div>
@endsection
