@extends('layouts.app')

@section('title', ' | Tags')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <h2>Tags</h2>

        @if(count($tags))
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>{{  $tag->id  }}</td>
                            <td>
                                <a href="{{  route('tags.show', $tag->id)  }}">{{  $tag->name  }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No tags found</p>
        @endif
        </div>

        <div class="well col-sm-4">
            <h2>New Tag</h2>

            {!! Form::open([
                    'route' => 'tags.store',
                    'method' => 'POST'
            ]) !!}
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
