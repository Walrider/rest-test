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
                                All Tags
                            </div>
                        </div>
                        @if($tags->count())
                            {{$tags->links()}}
                            <a class="btn btn-primary pull-right" href="{{route('tags.create')}}">Create Tag</a>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Tag Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tags as $tag)
                                    <tr>
                                        <td>
                                            <h3>{{$tag->title}}</h3>
                                        </td>
                                        <td>
                                            <a class="btn btn-success btn-block"
                                               href="{{route('tags.edit', [$tag->id])}}">Edit</a>
                                            <br>
                                            {!! Form::open(['route' => ['tags.destroy', $tag->id], 'method' => 'DELETE']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$tags->links()}}
                        @else
                            <div class="text-center">
                                <h1>Sorry, there are no tags right now</h1>
                                <a class="btn btn-success" href="{{route('tags.create')}}">Create Tag</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
