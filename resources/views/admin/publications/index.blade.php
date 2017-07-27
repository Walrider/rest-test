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
                                All Publications
                            </div>
                        </div>
                        @if($publications->count())
                            {{$publications->links()}}
                            <a class="btn btn-primary pull-right" href="{{route('publications.create')}}">Create
                                Publication</a>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Excerpt</th>
                                    <th>RES</th>
                                    <th>Published On</th>
                                    <th>Author</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($publications as $publication)
                                    <tr>
                                        <td>
                                            <h3>{{$publication->title}}</h3>
                                        </td>
                                        <td>
                                            <h3>{{str_limit($publication->text, 15)}}</h3>
                                        </td>
                                        <td>
                                            <h3>@if($publication->RES)
                                                    {{$publication->RES}}
                                                @else
                                                    None
                                                @endif
                                            </h3>
                                        </td>
                                        <td>
                                            <h3>{{$publication->created_at->toFormattedDateString()}}</h3>
                                        </td>
                                        <td>
                                            <h3>{{$publication->author->name}}</h3>
                                        </td>
                                        <td>
                                            <a class="btn btn-success btn-block"
                                               href="{{route('publications.edit', [$publication->id])}}">Edit</a>
                                            <br>
                                            {!! Form::open(['route' => ['publications.destroy', $publication->id], 'method' => 'DELETE']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$publications->links()}}
                        @else
                            <div class="text-center">
                                <h1>Sorry, there are no publications right now</h1>
                                <a class="btn btn-success" href="{{route('publications.create')}}">Create
                                    Publication</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
