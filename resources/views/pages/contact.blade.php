@extends('layouts.app')

@section('title', ' | Contact')

@section('content')
<div class="container">
    <h2>{{  $data['title']  }}</h2>

    {!! Form::open([
            'action' => 'ContactMailController@send',
            'method' => 'POST',
            'data-parsley-validate' => ''
    ]) !!}

        @csrf

        <div class="form-group">
            {{  Form::label('email', 'E-mail address')  }}
            {{  Form::text('email', '', [
                'class' => 'form-control',
                'placeholder' => 'Email',
                'required' => '',
                'maxlength' => '255',
                'data-parsley-maxlength' => '255'
            ])  }}
        </div>

        <div class="form-group">
            {{  Form::label('subject', 'Subject')  }}
            {{  Form::text('subject', '', [
                'class' => 'form-control',
                'placeholder' => 'Subject',
                'required' => '',
                'minlength' => '3',
                'maxlength' => '511',
                'data-parsley-minlength' => '3',
                'data-parsley-maxlength' => '511',
            ])  }}
        </div>

        <div class="form-group">
            {{  Form::label('message', 'Message')  }}
            {{  Form::textarea('message', '', [
                'id' => 'article-ckeditor',
                'class' => 'form-control',
                'placeholder' => 'Your message',
                'required' => ''
            ])  }}
        </div>

        {{  Form::submit('Send', [
            'class' => 'btn btn-primary'
        ])  }}
    {!! Form::close() !!}
</div>
@endsection
