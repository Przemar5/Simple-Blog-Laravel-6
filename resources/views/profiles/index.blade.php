@extends('layouts.app')

@section('title', ' | My Profile')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">My Profile</div>

        <div class="panel-body text-center">
            <h1 class="mb-5">{{  $data['title']  }}</h1>

            <div class="h4">
                <div class="row d-block py-5">
                    <strong>Name: </strong>
                    {{  $data['user']['name']  }}
                </div>
                <div class="row">
                    <strong>Email: </strong>
                    {{  $data['user']['email']  }}
                </div>
                <div class="row mt-5">
                    <a href="{{  route('profiles.edit')  }}" class="btn btn-primary">Change Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
