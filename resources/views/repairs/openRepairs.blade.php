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
<div class="bg-body-light">

    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 class="flex-sm-fill font-size-h2" style="padding-left: 50px;">All Open Repairs Table</h1>
        <a class="block text-center bg-gd-lake" href="javascript:void(0)">
            <div class="block-content block-content-full aspect-ratio-1-1 d-flex justify-content-center align-items-center">
                <div>
                    <div class="font-size-h1 font-w300 text-white">{{count($openrepairs)}}</div>
                    <div class="font-w600 mt-2 text-uppercase text-white-75">Repairs</div>
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
                        <th class="d-none d-sm-table-cell" style="width: 5%;">Repair ID</th>
                        <th class="d-none d-sm-table-cell" style="width: 20%;">Address</th>
                        <th style="width: 15%;">Lifts</th>
                        <th style="width: 15%;">Techinician</th>
                        <th style="width: 15%;">Quote No</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">View</th>
                        <th style="width: 15%;">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @if($openrepairs)
                    @foreach($openrepairs as $repair)
                    <tr>
                        <td class="text-center">

                            {{$repair->repair_time}}
                        </td>
                        <td class="font-w600">
                        <a href="/jobs/{{$repair->jobs->id}}">{{$repair->jobs->job_name}}</a>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{$repair->id}}
                        </td>
                        <td class="d-none d-sm-table-cell">
                        {{$repair->jobs->job_address_number}} {{$repair->jobs->job_address}}
                        </td>
                        <td>
                            @foreach ($repair->lifts as $lift)
                            <a href="/jobs/{{$repair->jobs->id}}/lifts/{{$lift->id}}">{{$lift->lift_name}}</a>
                            @endforeach
                        </td>
                        <td>
                            @if($repair->techs)
                            <a href="/techs/{{$repair->techs->id}}">{{$repair->techs->technician_name}}</a>
                            @endif
                        </td>
                        <td>
                            {{$repair->quote_no}}
                        </td>
                        <td>
                            @if($repair->repair_status_id == 1)
                            Open
                            @elseif($repair->repair_status_id == 2)
                            Closed
                            @endif
                        </td>
                        <td>
                            <a href="/repairs/{{$repair->id}}">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </div>
                            </a>
                        </td>
                        <td>
                        <form method="POST" action="/repairs/{{$repair->id}}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Delete">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- Delete Modal Table Full -->

</div>

@endsection
