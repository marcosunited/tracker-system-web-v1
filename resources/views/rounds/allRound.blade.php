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
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">All Rounds Table</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                </nav>
            </div>
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
                                        <th style="width:10%;">Color</th>
                                        <th class="d-none d-sm-table-cell">Status</th>
                                        <th class="d-none d-sm-table-cell" style="width: 10%;">Job Count</th>
                                        <th style="width: 10%;">Lift Count</th>
                                        <th style="width: 10%;">Action</th>
                                        <th style="width: 10%;">Show Job</th>
                                        <th style="width: 10%;">Map</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($rounds as $round)
                                    <tr>
                                        <td class="text-center">{{$round->round_name}}</td>
                                        <td bgcolor="{{$round->round_colour}}">
                                            
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                        @if ($round->status_id == 1)
                                                Active
                                        @else
                                                Inactive
                                        @endif
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            {{count($round->jobs)}}
                                        </td>                                      
                                        <td>   
                                        {{\AppHelper::instance()->round_lift_count($round->id)}}                                        
                                        </td>
                                        </td>
                                        </td>
                                        <td> 
                                        <a href = "/rounds/{{$round->id}}">
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </button>                                         
                                       </td>
                                        </td>
                                        <td>  
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-book"></i>
                                                </button>                                        
                                        </td>
                                        </td>
                                        <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-map"></i>
                                        </button>  
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
