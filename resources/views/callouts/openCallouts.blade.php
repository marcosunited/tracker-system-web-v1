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
      var callout_id = button.data('calloutid') 
      var modal = $(this)
      modal.find('.modal-content #callout_id').val(callout_id);
}) });

</script>
@endsection

@section('content')
<!-- Hero -->
<div class="bg-body-light">

    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 class="flex-sm-fill font-size-h2" style="padding-left: 50px;">All Open Callouts Table</h1>
        <a class="block text-center bg-gd-lake" href="javascript:void(0)">
            <div class="block-content block-content-full aspect-ratio-1-1 d-flex justify-content-center align-items-center">
                <div>
                    <div class="font-size-h1 font-w300 text-white">{{count($openCallouts)}}</div>
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
                        <th style="width: 20%;">Job Number</th>
                        <th class="d-none d-sm-table-cell" style="width: 5%;">Callout ID</th>
                        <th class="d-none d-sm-table-cell" style="width: 20%;">Address</th>
                        <th style="width: 15%;">Reported Fault</th>
                        <th style="width: 15%;">Lifts</th>
                        <th style="width: 15%;">Techinician</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Accept Status</th>
                        <th style="width: 15%;">View</th>
                        <th style="width: 15%;">SMS</th>
                        <th style="width: 15%;">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @if($openCallouts)
                    @foreach($openCallouts as $callout)
                    <?php 
                    if ($callout->accept_decline ==1 ) $bgcolor='lightgreen';
                    if ($callout->accept_decline ==2 ) $bgcolor='red';
                    if ($callout->accept_decline == 0 ) $bgcolor='yellow';
                    ?>
                    <tr  style="background-color:{{$bgcolor}}">
                        <td class="text-center">

                        {{date('d-m-yy H:i:s',strtotime($callout->callout_time))}}
                        </td>
                        <td class="font-w600">
                        <a href="/jobs/{{$callout->jobs->id}}">{{$callout->jobs->job_name}}</a>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{$callout->jobs->job_number}}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{$callout->id}}
                        </td>
                        <td class="d-none d-sm-table-cell">
                        {{$callout->jobs->job_address_number}} {{$callout->jobs->job_address}}
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
                            <a href="/techs/{{$callout->techs->id}}">{{$callout->techs->technician_name}}</a>
                            @endif
                        </td>
                        </td>
                        <!-- <td>
                            @if($callout->priority_id == 1)
                            Low
                            @elseif($callout->priority_id == 2)
                            Medium
                            @elseif($callout->priority_id == 3)
                            High
                            @endif
                        </td> -->
                        </td>
                        <td>
                            Open
                        </td>
                        <td>
                            @if ($callout->accept_decline==0)
                            Pending
                            @elseif ($callout->accept_decline==1)
                            Accepted
                            @else
                            Declined
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
                            <a href="/callouts/{{$callout->id}}">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-sms"></i>
                                    </button>
                                </div>
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#delete-modal" data-calloutid={{$callout->id}}>
                                <i class="fa fa-times"></i></button>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
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

                        <form method="POST" action="/callouts/0">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="callout_id" id="callout_id" value="">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
