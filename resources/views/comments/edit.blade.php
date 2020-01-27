@extends('layouts.app')

@section('title', ' | Edit comment')

@section('links')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" integrity="sha256-7stu7f6AB+1rx5IqD8I+XuIcK4gSnpeGeSjqsODU+Rk=" crossorigin="anonymous" />
@endsection

@section('content')
<div class="container">
    <h2>Edit comment</h2>
    {!! Form::open([
            'action' => ['CommentController@update', $comment->id],
            'method' => 'PATCH',
            'enctype' => 'multipart/form-data',
            'data-parsley-validate' => ''
    ]) !!}

    @csrf

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{  Form::label('author', 'Name')  }}
                {{  Form::text('author', $comment->author, [
                    'class' => 'form-control',
                    'placeholder' => 'Your name',
                    'required' => '',
                    'maxlength' => '255',
                    'data-parsley-maxlength' => '255'
                ])  }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{  Form::label('email', 'Email')  }}
                {{  Form::text('email', $comment->email, [
                    'class' => 'form-control',
                    'placeholder' => 'Email address',
                    'maxlength' => '255',
                    'data-parsley-maxlength' => '255'
                ])  }}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {{  Form::label('comment', 'Comment')  }}
                {{  Form::textarea('comment', $comment->comment, [
                    'class' => 'form-control',
                    'rows' => '5',
                    'required' => '',
                    'placeholder' => 'Your comment...',
                    'maxlength' => '255',
                    'data-parsley-maxlength' => '255'
                ])  }}
            </div>
        </div>

        {{  Form::hidden('post_id', $comment->post_id)  }}

        <div class="col-md-12">
            {{  Form::submit('Update Comment', [
                'class' => [
                    'btn',
                    'btn-primary',
                    'btn-block'
                ]
            ])  }}
        </div>
    {!! Form::close() !!}
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
@endsection
