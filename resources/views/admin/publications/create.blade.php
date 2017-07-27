@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Admin Dashboard</div>

                    <div class="panel-body">
                        <div class="content">
                            <div class="title m-b-md">
                                New Publication
                            </div>
                        </div>
                        @include('errors.list')
                        {!! Form::model($publication = new LoremPublishing\Publication, ['route' => 'publications.store', 'files'=>true]) !!}
                        <div class="form-group">
                            {!! Form::label('title', 'Publication title:') !!}
                            {!! Form::text('title', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('text', 'Text:') !!}
                            {!! Form::textarea('text', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('cover_image', 'Cover image:') !!}
                            {!! Form::file('cover_image', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tag_list', 'Tags:') !!}
                            {!! Form::select('tag_list[]',  $tags, null, ['id' => 'tags' ,'class' => 'form-control', 'multiple']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Save', ['class' => 'btn btn-success btn-block']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
