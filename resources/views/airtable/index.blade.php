@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-0">
                            <li class="breadcrumb-item active" aria-current="page">
                                AirTable data
                            </li>
                        </ol>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if(count($treeData))
                            @foreach($treeData as $treeRowData)
                                <ul>
                                    <li>
                                        <div class="model-field">
                                            <label class="font-weight-bold model-data-label">{{__('Number:')}}</label>
                                            {{$treeRowData['number']}}
                                        </div>
                                        <div class="model-field">
                                            <label class="font-weight-bold model-data-label">{{__('Description:')}}</label>
                                            {{$treeRowData['description']}}
                                        </div>
                                        <div class="model-field">
                                            <label class="font-weight-bold model-data-label">{{__('Unit:')}}</label>
                                            {{$treeRowData['unit']}}
                                        </div>
                                        @if(array_key_exists('children', $treeRowData))
                                            <div class="model-field">
                                                <label class="font-weight-bold model-data-label">{{__('Children:')}}</label>
                                                    <?php
                                                    $children = $treeRowData['children']
                                                    ?>
                                                <ul>
                                                    @foreach($children as $childrenDataRow)
                                                        <li class="model-child-line">
                                                            <div class="child-data-field"><label
                                                                    class="font-weight-bold child-data-label">{{__('ID:')}}</label> {{$childrenDataRow['id']}}
                                                            </div>
                                                            <div class="child-data-field"><label
                                                                    class="font-weight-bold child-data-label">{{__('Description:')}}</label> {{implode(',', $childrenDataRow['description'])}}
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @if(array_key_exists('parents', $treeRowData))
                                            <div class="model-field">
                                                <label class="font-weight-bold model-data-label">{{__('Children:')}}</label>
                                                    <?php
                                                    $parents = $treeRowData['parents']
                                                    ?>
                                                <ul>
                                                    @foreach($parents as $parentDataRow)
                                                        <li class="model-parents-line">
                                                            <div class="parent-data-field"><label
                                                                    class="font-weight-bold parent-data-label">{{__('ID:')}}</label> {{$parentDataRow['id']}}
                                                            </div>
                                                            <div class="parent-data-field"><label
                                                                    class="font-weight-bold parent-data-label">{{__('Description:')}}</label> {{implode(',', $parentDataRow['description'])}}
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </li>
                                </ul>
                            @endforeach
                        @else
                            <div class="text-center">
                                <p>{{__('You do not have any data on Air Table yet')}}</p>
                            </div>
                        @endif
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
