@extends('layouts.app')

@section('title', ' | Show category: '.htmlspecialchars($category->name))

@section('content')
<div class="container">
    <a href="{{  route('categories.index')  }}" class="btn btn-default">Go back</a>

    <div class="row">
        <div class="col-8">
            <h2>Category: {{  $category->name  }}
                <small>{{  $category->posts->count()  }} {{  $category->posts->count() !== 1 ? 'Posts' : 'Post'  }}</small>
            </h2>
        </div>

        <div class="col-2">
            <a href="{{  route('categories.edit', $category->id)  }}" class="btn btn-default pull-right">Edit</a>
        </div>

        <div class="col-2">
            {!! Form::open([
                'action' => ['CategoryController@destroy', $category->id],
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

    @if(count($category->posts))
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
            @foreach($category->posts as $post)
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
