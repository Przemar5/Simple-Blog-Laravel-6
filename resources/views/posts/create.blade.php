@extends('layouts.app')

@section('title', ' | Create post')

@section('links')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" integrity="sha256-7stu7f6AB+1rx5IqD8I+XuIcK4gSnpeGeSjqsODU+Rk=" crossorigin="anonymous" />
@endsection

@section('content')
<div class="container">
    <h2>Create Post</h2>
    {!! Form::open([
            'action' => 'PostController@store',
            'method' => 'POST',
            'enctype' => 'multipart/form-data',
            'data-parsley-validate' => ''
    ]) !!}

        @csrf

        <div class="form-group">
            {{  Form::label('title', 'Title')  }}
            {{  Form::text('title', '', [
                'class' => 'form-control',
                'placeholder' => 'Title',
                'required' => '',
                'maxlength' => '255',
                'data-parsley-maxlength' => '255'
            ])  }}
        </div>

        <div class="form-group">
            {{  Form::label('slug', 'Slug')  }}
            {{  Form::text('slug', '', [
                'class' => 'form-control',
                'placeholder' => 'Slug',
                'required' => '',
                'minlength' => '5',
                'maxlength' => '255',
                'data-parsley-minlength' => '5',
                'data-parsley-maxlength' => '255',
            ])  }}
        </div>

            @if(count($data['categories']))
            <div class="form-group">
                {{  Form::label('category_id', 'Category')  }}
                {{  Form::select('category_id', $data['categories'], '', [
                    'class' => 'form-control',
                    'required' => ''
                ])  }}
            </div>
            @endif

            @if(count($data['tags']))
            <div class="form-group">
                {{  Form::label('tags', 'Tags')  }}
                {{  Form::select('tags[]', $data['tags'], '', [
                    'class' => 'form-control',
                    'multiple' => 'multiple'
                ])  }}
            </div>
            @endif

        <div class="form-group">
            {{  Form::label('body', 'Body')  }}
            {{  Form::textarea('body', '', [
                'id' => 'article-ckeditor',
                'class' => 'form-control',
                'placeholder' => 'Body Text',
                'required' => ''
            ])  }}
        </div>

        <div class="form-group">
            {{  Form::label('cover_image', 'Image')  }}
            {{  Form::file('cover_image')  }}
        </div>

        {{  Form::hidden('_method', 'POST')  }}

        {{  Form::submit('Create', [
            'class' => 'btn btn-primary btn-block'
        ])  }}
    {!! Form::close() !!}
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js" integrity="sha256-qoj3D1oB1r2TAdqKTYuWObh01rIVC1Gmw9vWp1+q5xw=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="tags[]"]').multiselect();


            setTimeout(function(){
                $('select[name="tags[]"]').multiselect();
            }, 800);
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
@endsection
