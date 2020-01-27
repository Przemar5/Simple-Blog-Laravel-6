@extends('layouts.app')

@section('title', ' | Edit tag: '.htmlspecialchars($tag->name))

@section('content')
<div class="container">
    <h2>Edit Tag</h2>

    {!! Form::open([
            'action' => ['TagController@update', $tag->id],
            'method' => 'PATCH',
            'data-parsley-validate' => ''
    ]) !!}

        @csrf

        <div class="form-group">
            {{  Form::label('name', 'Tag name')  }}
            {{  Form::text('name', $tag->name, [
                'class' => 'form-control',
                'placeholder' => 'Tag name',
                'required' => '',
                'maxlength' => '255',
                'data-parsley-maxlength' => '255'
            ])  }}
        </div>

        {{  Form::hidden('_method', 'PATCH')  }}

        {{  Form::submit('Change', [
            'class' => 'btn btn-primary'
        ])  }}
    {!! Form::close() !!}
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
@endsection
