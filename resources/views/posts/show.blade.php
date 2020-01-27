@extends('layouts.app')

@section('title', ' | '.htmlspecialchars($post->title))

@section('content')
<div class="container">
    <a href="{{  route('posts.index')  }}" class="btn btn-default">Go back</a>

    <h2>{{  $post->title  }}</h2>

    <div>
        <img src="/storage/cover_images/{{  $post->cover_image  }}" alt="" class="w-100 mb-3 float-left" style="max-width: 40rem;">
        <p>{!!  $post->body  !!}</p>
    </div>

    <small>Written on {{  $post->created_at  }} by {{  $post->user->name ?? ''  }}</small>
    <p>Posted in: {{  $post->category->name ?? ''  }}</p>

    <div class="tags">
        @foreach($post->tags as $tag)
            <span class="label label-default">
            {{  $tag->name  }}
            </span>
        @endforeach
    </div>

    <hr>

    @if(Auth::user()->id == $post->user_id)
        <a href="{{  route('posts.edit', $post->slug)  }}" class="btn btn-default">Edit</a>

        {!!  Form::open([
                'action' => ['PostController@destroy', $post->slug],
                'method' => 'POST',
                'class' => 'pull-right',
        ])  !!}

            @csrf

            {{  Form::hidden('_method', 'DELETE')  }}

            {{  Form::submit('Delete', [
                    'class' => 'btn btn-danger'
            ])  }}
        {!!  Form::close()  !!}

        <div id="comment-admin-panel">
            <h3>Comments: <small>{{  $post->comments()->count()  }} total</small></h3>

            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Comment</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($post->comments as $comment)
                    <tr>
                        <td>{{  $comment->author  }}</td>
                        <td>{{  $comment->email  }}</td>
                        <td>{{  $comment->comment  }}</td>
                        <td class="text-right admin-table-buttons">
                            <a href="{{  route('comments.edit', $comment->id)  }}" class="btn btn-default btn-sm btn-edit" >
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            {!!  Form::open([
                                'action' => ['CommentController@destroy', $comment->id],
                                'method' => 'POST',
                                'class' => 'pull-right',
                            ])  !!}

                                @csrf

                                {{  Form::hidden('_method', 'DELETE')  }}

                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                    Delete
                                </button>
                            {!!  Form::close()  !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="row mt-5">
        <div class="col-md-8 col-md-offset-2">
            <h2>
                <i class="fas fa-comment"></i>
                <span class="ml-5">{{  $post->comments()->count()  }} Comments</span>
            </h2>

        @if(count($post->comments))
            @foreach($post->comments as $comment)
                <div class="comment well">
                    <div class="comment__heading">
                        <div class="comment__heading--left">
                            <img src="{{  'https://www.gravatar.com/avatar/'.md5(strtolower(trim($comment->email))).'?s=50&d=mp'  }}" alt="" class="comment__author-image">
                        </div>

                        <div class="comment__heading--right">
                            <h4 class="comment__author-name">
                                {{  $comment->author  }}
                            </h4>
                            <small class="comment__date text-muted">{{  $comment->updated_at ? 'Updated on '.date('F nS, Y - G:i', strtotime($comment->updated_at)) : 'Created on '.date('F nS, Y - G:i', strtotime($comment->created_at))  }}</small>
                        </div>
                    </div>

                    <div class="comment__content">
                        <p>{{  $comment->comment  }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <p>There are no comments yet. Be the first!</p>
        @endif
        </div>
    </div>

    <div class="row">
        <div id="comment-form" class="col-md-8 col-md-offset-2">
            {{  Form::open([
                'action' => 'CommentController@store',
                'method' => 'POST',
                'data-parsley-validate' => ''
            ])  }}

                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{  Form::label('author', 'Name')  }}
                            {{  Form::text('author', '', [
                                'class' => 'form-control',
                                'placeholder' => 'Your name'
                            ])  }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {{  Form::label('email', 'Email')  }}
                            {{  Form::text('email', '', [
                                'class' => 'form-control',
                                'placeholder' => 'Email address'
                            ])  }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            {{  Form::label('comment', 'Comment')  }}
                            {{  Form::textarea('comment', '', [
                                'class' => 'form-control',
                                'rows' => '5',
                                'placeholder' => 'Your comment...'
                            ])  }}
                        </div>
                    </div>

                    {{  Form::hidden('post_id', $post->id)  }}

                    <div class="col-md-12">
                        {{  Form::submit('Add Comment', [
                            'class' => [
                                'btn',
                                'btn-primary',
                                'btn-block'
                            ]
                        ])  }}
                    </div>
                </div>

            {{  Form::close()  }}
        </div>
    </div>
</div>
@endsection
