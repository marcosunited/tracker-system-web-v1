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
                <h1 class="flex-sm-fill font-size-h2" style="padding-left: 50px;">All Jobs Table</h1>
                <a class="block text-center bg-gd-lake" href="javascript:void(0)">
                <div class="block-content block-content-full aspect-ratio-1-1 d-flex justify-content-center align-items-center">
                    <div>
                        <div class="font-size-h1 font-w300 text-white">{{count($jobs)}}</div>
                        <div class="font-w600 mt-2 text-uppercase text-white-75">Jobs</div>
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
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center" style="width:10%;">Job Number</th>
                                        <th class="text-center" style="width:10%;">Contract status</th>
                                        <th class="text-center" style="width:6%;">Contract frequency</th>
                                        <th style="width:5%;">Lifts</th>
                                        <th class="d-none d-sm-table-cell" style="width: 20%;">Job name</th>
                                        <th class="d-none d-sm-table-cell" style="width: 10%;">Number</th>
										<th class="d-none d-sm-table-cell" style="width: 10%;">Status</th>
                                        <th style="width: 10%;">Street</th>
                                        <th style="width: 10%;">Suburb</th>
                                        <th style="width: 10%;">Group</th>
                                        <th style="width: 10%;">Round</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($jobs as $job)
                                    <tr>
                                        <td class="text-center">{{$job->job_number}}</td>
										<td class="text-center">
											<img style="width:24px" src="../image/images/icons/{{$job->contract_icon}}" />
                                        </td>
                                        <td class="font-w600">
                                            {{$job->frequency_name}}
                                        </td>
                                        <td class="font-w600">
                                            {{$job->lift_count}}
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            {{$job->job_name}}
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            {{$job->job_address_number}}
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            {{$job->status_name}}
                                        </td>
                                        <td>
                                            {{$job->job_address}}
                                        </td>
                                        </td>
                                        <td>
                                            {{$job->job_suburb}}
                                        </td>
                                        </td>
                                        <td>
                                            {{$job->job_group}}
                                        </td>
                                        </td>
                                        <td bgcolor="{{$job->round_colour}}">
                                            <font color="white">{{$job->round_name}}</font>
                                        </td>
                                        </td>
                                        <td>
                                        <div class="btn-group">
                                                <a href = "/jobs/{{$job->id}}">
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </button>
                                                </a>
                                        </div>
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
