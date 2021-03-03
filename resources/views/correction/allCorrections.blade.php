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
        <script>
        $(document).ready(function() {  $('#delete-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var correction_id = button.data('correctionid') 
            var modal = $(this)
            modal.find('.modal-content #correction_id').val(correction_id);
        }) });
        </script>
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">

            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2" style="padding-left: 50px;">All Correction Table</h1>
                <a class="block text-center bg-gd-lake" href="javascript:void(0)">
                <div class="block-content block-content-full aspect-ratio-1-1 d-flex justify-content-center align-items-center">
                    <div>
                        <div class="font-size-h1 font-w300 text-white">{{count($corrections)}}</div>
                        <div class="font-w600 mt-2 text-uppercase text-white-75">Corrections</div>
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
                                        <th class="text-center" >Name</th>                                       
                                        <th >Type</th>
                                        <th style="width: 10%;">View</th>
                                        <th style="width: 10%;">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($corrections as $correction)
                                    <tr>
                                        <td>{{$correction->correction_name}}</td>
                                        <td>{{$correction->type}}</td>
                                        <td>                                       
                                        <div class="btn-group">
                                                <a href = "/correction/{{$correction->id}}">
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </button>
                                                </a>
                                        </div>
                                        <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#delete-modal" data-correctionid={{$correction->id}}>
                                            <i class="fa fa-times"></i></button>
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

        <!-- END Dynamic Table Full -->

        <!-- Delete Modal Table Full -->

        <div class="modal" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Delete Confirmation</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <h5>Are you Sure?</h5>

                        <form method="POST" action="/correction/0">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="correction_id" id="correction_id" value="">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

