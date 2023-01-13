@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-0">
                        <li class="breadcrumb-item active" aria-current="page">
                            Sites
                        </li>
                    </ol>
                    <div class="float-right">
                        <a class="btn btn-primary text-white" href="{{route('sites.export')}}">{{__('Export All')}}</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(count($sites))
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Base ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sites as $site)
                                <tr>
                                    <td>{{ $site->id }}</td>
                                    <td>
                                        <a href="/sites/{{ $site->id }}">{{ $site->name }}</a>
                                    </td>

                                    <td>{{$site->type}}</td>
                                    <td>
                                        {{$site->airtable_base_id}}
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-info" href="{{route('airtable.index', ['id' => $site->id])}}">View airtable data</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <p>You have not created any sites yet.</p>
                        </div>
                    @endif
                        <hr>
                        <div class="text-center">
                            <a class="btn btn-primary" href="/sites/create">New site</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
