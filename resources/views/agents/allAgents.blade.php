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
        <h1 class="flex-sm-fill font-size-h2" style="padding-left: 50px;">All Agents Table</h1>
        <a class="block text-center bg-gd-lake" href="javascript:void(0)">
            <div class="block-content block-content-full aspect-ratio-1-1 d-flex justify-content-center align-items-center">
                <div>
                    <div class="font-size-h1 font-w300 text-white">{{count($agents)}}</div>
                    <div class="font-w600 mt-2 text-uppercase text-white-75">Agents</div>
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
                        <th class="text-center" style="width:10%;">Name</th>
                        <th style="width:10%;">Address</th>
                        <th style="width: 10%;">Phone Number</th>
                        <th style="width: 10%;">Fax</th>
                        <th style="width: 10%;">View</th>
                        <th style="width: 10%;">Delete</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($agents as $agent)
                    <tr>
                        <td class="text-center">{{$agent->agent_name}}
                        </td>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{$agent->agent_address}}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{$agent->agent_phone}}
                        </td>
                        <td>
                            {{$agent->agent_fax}}
                        </td>
                        <td>
                            <a href="/agents/{{$agent->id}}">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="/agents/{{$agent->id}}">
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
