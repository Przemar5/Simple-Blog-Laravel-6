@extends('layouts.app')

@section('title', ' | Show tag: '.htmlspecialchars($tag->name))

@section('content')
<div class="container">
    <a href="{{  route('tags.index')  }}" class="btn btn-default">Go back</a>

    <div class="row">
        <div class="col-8">
            <h2>Tag: {{  $tag->name  }}
                <small>{{  $tag->posts->count()  }} {{  $tag->posts->count() !== 1 ? 'Posts' : 'Post'  }}</small>
            </h2>
        </div>

        <div class="col-2">
            <a href="{{  route('tags.edit', $tag->id)  }}" class="btn btn-default pull-right">Edit</a>
        </div>

        <div class="col-2">
            {!! Form::open([
                'action' => ['TagController@destroy', $tag->id],
                'method' => 'POST',
                'class' => 'pull-right',
            ])  !!}

                @csrf

                {{  Form::hidden('_method', 'DELETE')  }}

                {{  Form::submit('Delete', [
                        'class' => 'btn btn-danger'
                ])  }}
            {!!  Form::close()  !!}
        </div>
    </div>

    @if(count($tag->posts))
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Tags</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($tag->posts as $post)
                <tr>
                    <td>{{  $post->id  }}</td>
                    <td>{{  $post->title  }}</td>
                    <td>{{  $post->category->name  }}</td>
                    <td>
                        @foreach($post->tags as $tag)
                            <span class="label label-default">{{  $tag->name  }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{  route('posts.show', $post->slug)  }}" class="btn btn-default btn-sm">Show</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>There are no posts with this tag</p>
    @endif
</div>
@endsection
