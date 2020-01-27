@extends('layouts.app')

@section('title', ' | Categories')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <h2>Categories</h2>

        @if(count($categories))
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{  $category->id  }}</td>
                            <td>
                                <a href="{{  route('categories.show', $category->id)  }}">{{  $category->name  }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No categories found</p>
        @endif
        </div>

        <div class="well col-sm-4">
            <h2>New Category</h2>

            {!! Form::open([
                    'route' => 'categories.store',
                    'method' => 'POST'
            ]) !!}

                @csrf

                {{ Form::label('name', 'Name:') }}
                {{ Form::text('name', '', [
                    'class' => 'form-control',
                    'required' => '',
                    'maxlength' => '255',
                    'data-parsley-maxlength' => '255'
                ]) }}

                {!! Form::submit('Create', [
                    'class' => 'btn btn-primary btn-block'
                ]) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
