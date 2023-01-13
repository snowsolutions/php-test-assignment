@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-0">
                            <li class="breadcrumb-item active" aria-current="page">
                                Site Information # {{$site->id}}
                            </li>
                        </ol>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <hr>
                        <div class="card">
                            <div class="card-body">
                                <div class="site-name">
                                    <label class="font-weight-bold" for="">{{__('Name:')}}</label>
                                    <span class="data">{{$site->name}}</span>
                                </div>
                                <div class="site-name">
                                    <label class="font-weight-bold" for="">{{__('Type:')}}</label>
                                    <span class="data">{{$site->type}}</span>
                                </div>
                                <div class="site-access-key">
                                    <label class="font-weight-bold" for="">{{__('Access Key:')}}</label>
                                    <span class="data">{{$site->airtable_access_key}}</span>
                                </div>
                                <div class="site-base-id">
                                    <label class="font-weight-bold" for="">{{__('Base ID:')}}</label>
                                    <span class="data">{{$site->airtable_base_id}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 float-right">
                            <a href="{{route('sites.index')}}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
