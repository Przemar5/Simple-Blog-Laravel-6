@extends('layouts.app')

@section('title', ' | Edit category: '.htmlspecialchars($category->name))

@section('content')
<div class="container">
    <h2>Edit Category</h2>

    {!! Form::open([
            'action' => ['CategoryController@update', $category->id],
            'method' => 'PATCH',
            'data-parsley-validate' => ''
    ]) !!}

        @csrf

        <div class="form-group">
            {{  Form::label('name', 'Category name')  }}
            {{  Form::text('name', $category->name, [
                'class' => 'form-control',
                'placeholder' => 'Category name',
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
