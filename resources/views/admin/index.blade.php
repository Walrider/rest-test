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
                                Home, sweet home
                            </div>

                            <div class="links">
                                <a href="{{route('publications.index')}}">Publications Management</a>
                                <a href="{{route('tags.index')}}">Tags Management</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
