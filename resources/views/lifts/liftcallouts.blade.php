@extends('layouts.backend')

@section('css_before')
<link rel="stylesheet" href="{{asset('js/plugins/datatables/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css')}}">
@endsection

@section('js_after')
<!-- Page JS Plugins -->
<script src="{{asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons/buttons.colVis.min.js')}}"></script>

<!-- Page JS Code -->
<script src="{{asset('js/pages/be_tables_datatables.min.js')}}"></script>
@endsection

@section('content')
<!-- Hero -->
<div class="bg-white inner-top-bar">
    <div class="content">
        <!-- Toggle Main Navigation -->

        <!-- END Toggle Main Navigation -->

        <!-- Main Navigation -->
        @include('layouts.innerJobNav')
        <!-- END Main Navigation -->
    </div>
</div>
<div class="bg-body-light">

    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 class="flex-sm-fill font-size-h2" style="padding-left: 50px;">All Lift No: {{$lift->lift_name}} Callouts -> {{$job->job_name}}</h1>
        <a class="block text-center bg-gd-lake" href="javascript:void(0)">
            <div class="block-content block-content-full aspect-ratio-1-1 d-flex justify-content-center align-items-center">
                <div>
                    <div class="font-size-h1 font-w300 text-white">{{count($liftcallouts)}}</div>
                    <div class="font-w600 mt-2 text-uppercase text-white-75">Callouts</div>
                </div>
            </div>
        </a>

    </div>
</div>
<!-- END Hero -->
<!-- Page Content -->
<div class="content">
    <!-- Dynamic Table Full -->
    <div class="block block-rounded block-bordered">
        <div class="block-content block-content-full">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
            <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                <thead>
                    <tr>
                        <th class="text-center" style="width:10%;">Time</th>
                        <th style="width: 20%;">Job Name</th>
                        <th class="d-none d-sm-table-cell" style="width: 5%;">Callout ID</th>
                        <th class="d-none d-sm-table-cell" style="width: 20%;">Address</th>
                        <th style="width: 15%;">Reported Fault</th>
                        <th style="width: 15%;">Lifts</th>
                        <th style="width: 15%;">Techinician</th>
                        <th style="width: 15%;">Priority</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">View</th>
                        <th style="width: 15%;">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($liftcallouts as $callout)
                    <tr>
                        <td class="text-center">
                         {{$callout->callout_time}}
                        </td>
                        <td class="font-w600">
                        <a href="/jobs/{{$callout->jobs->id}}">{{$callout->jobs->job_name}}</a>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{$callout->id}}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{$callout->jobs->job_address}}
                        </td>
                        <td>
                            @if($callout->faults)
                            {{$callout->faults->fault_name}}
                            @endif
                        </td>
                        </td>
                        <td>
                        @foreach ($callout->lifts as $lift)
                                <a href="/jobs/{{$callout->jobs->id}}/lifts/{{$lift->id}}">{{$lift->lift_name}}</a>
                        @endforeach
                        </td>
                        </td>
                        <td>
                            @if($callout->techs)
                            {{$callout->techs->technician_name}}
                            @endif
                        </td>
                        </td>
                        <td>
                            @if($callout->priority_id == 1)
                            Low
                            @elseif($callout->priority_id == 2)
                            Medium
                            @elseif($callout->priority_id == 3)
                            High
                            @endif
                        </td>
                        </td>
                        <td>
                            @if($callout->callout_status_id == 1)
                            Open
                            @elseif($callout->callout_status_id == 2)
                            Closed
                            @elseif($callout->callout_status_id == 3)
                            Shutdown
                            @elseif($callout->callout_status_id == 4)
                            FollowUp
                            @elseif($callout->callout_status_id == 5)
                            UnderRepair
                            @endif
                        </td>
                        </td>
                        <td>
                            <a href="/callouts/{{$callout->id}}">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </div>
                            </a>
                        </td>
                        <td>
                        <form method="POST" action="/callouts/{{$callout->id}}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Delete">
                                    <i class="fa fa-times"></i>
                                </button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Dynamic Table Full -->
</div>
<!-- END Page Content -->
@endsection
