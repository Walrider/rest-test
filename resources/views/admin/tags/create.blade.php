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
                                New Tag
                            </div>
                        </div>
                        @include('errors.list')
                        {!! Form::model($tag = new LoremPublishing\Tag, ['route' => 'tags.store']) !!}
                        <div class="form-group">
                            {!! Form::label('title', 'Tag title:') !!}
                            {!! Form::text('title', null, ['class'=>'form-control']) !!}
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
