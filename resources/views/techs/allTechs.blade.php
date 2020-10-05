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
    $(document).ready(function() {

        $('a[data-toggle=modal], button[data-toggle=modal]').click(function() {

            var data_id = 0;

            if ($(this).data('mainid') !== '') {

                data_id = $(this).data('mainid');
            }

            $('#deleteAction').attr("action", '/techs/' + data_id);
        })
    });
</script>

@endsection


@section('content')
<!-- Hero -->
<div class="bg-body-light">

    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 class="flex-sm-fill font-size-h2" style="padding-left: 50px;">All Technicians Table</h1>
        <a class="block text-center bg-gd-lake" href="javascript:void(0)">
            <div class="block-content block-content-full aspect-ratio-1-1 d-flex justify-content-center align-items-center">
                <div>
                    <div class="font-size-h1 font-w300 text-white">{{count($techs)}}</div>
                    <div class="font-w600 mt-2 text-uppercase text-white-75">Technicians</div>
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
                        <th class="text-center" style="width:10%;">Tech Name</th>
                        <th style="width:10%;">Phones</th>
                        <th class="d-none d-sm-table-cell" style="width: 20%;">Email</th>
                        <th class="d-none d-sm-table-cell" style="width: 10%;">Status</th>
                        <th style="width: 10%;">Round</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    @foreach($techs as $tech)
                    <tr>
                        <td class="text-center">
                            {{$tech->technician_name}}
                        </td>
                        <td class="font-w600">
                            {{$tech->technician_phone}}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{$tech->technician_email}}
                        </td>
                        <td>
                            @if ($tech->status_id == 1)
                            Active
                            @else
                            Inactive
                            @endif
                        </td>
                        <td class="d-none d-sm-table-cell" bgcolor="{{isset($tech->rounds)?$tech->rounds->round_colour:'fffff'}}">
                            <font color="white">{{isset($tech->rounds)?$tech->rounds->round_name:'N/a'}}</font>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="/techs/{{$tech->id}}">
                                    <button type="button" class="btn btn-sm btn-primary action-buttons" data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </a>
                                <button type="button" class="btn btn-sm btn-primary action-buttons" data-toggle="modal" title="Remove" data-target="#delete-modal" data-mainid={{$tech->id}}>
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Dynamic Table Full -->
    <div class="modal" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Are you sure?</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <h5>This action will remove the technician permanently and he won't able to login in the app anymore</h5>
                        <form method="POST" action="/techs/" id="deleteAction">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="tech_id" id="tech_id" value="">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->
@endsection