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
     const button = $(event.relatedTarget);
     const callout_id = button.data('mainid');
     const modal = $(this);
     modal.find('.modal-content #maintenance_id').val(callout_id);
})
});
$(document).ready(function() {
    $(document).on('click','.act_send',function(event) {
        const main_id = $(this).data('mainid');
        $('#main_send_id').val(main_id);
        $('#send_form').trigger('submit');
    });
    $(document).on('click','.act_print',function(event) {
        const main_id = $(this).data('mainid');
        $('#main_print_id').val(main_id);
        $('#print_form').trigger('submit');
    });

});
</script>

<script type="text/javascript">

    $(document).ready(function() {
        let table = $('#mytabla').DataTable({
            retrieve: true,
        });
        table.destroy();

        table = $('#mytabla').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_finished_maintenances') }}",
            columns: [
                {"data": "maintenance_date"},
                {"data": "job_number",
                 "name": "jobs.job_number"},
                {
                     "data": "job_name",
                     "name": "jobs.job_name",
                     "render": function(data, type, row){
                         if(type === 'display'){
                             data = '<a href="/jobs/' + row.job_id + '">' + data + '</a>';
                         }
                         return data;
                     }
                },
                {"data": "id"},
                {"data": "job_address",
                 "name": "jobs.job_address"},
                {"data": "job_group",
                 "name": "jobs.job_group"},
                {"data": "lift_name",
                 "name": "lifts.lift_name",
                 "render": function(data, type, row){
                     if(type === 'display'){
                         data = '<a href="/jobs/' + row.job_id + '/lifts/' + row.lift_id + '">' + data + '</a>';
                     }
                     return data;
                 }},
                {"data": "technician_name",
                 "name": "techs.technician_name",
                 "render": function(data, type, row){
                     if(type === 'display'){
                         data = '<a href="/techs/' + row.technician_id + '">' + data + '</a>';
                     }
                     return data;
                 }},
                {"data": "report_status",
                    "render": function(data, type, row){
                        if(type === 'display'){
                            if(data == 'none'){
                                data = '<a data-mainid=' + row.id + ' class="act_send btn btn-success btn-sm text-white">Send  &nbsp; Email</a>';
                                data = data  + '<a data-mainid=' + row.id + ' class="act_print btn btn-warning btn-sm text-white">Print Report</a>';
                            }else if(data == 'sent'){
                                data = 'Sent Email<br> <a data-mainid=' + row.id + ' class="act_print btn btn-success btn-sm text-white">Send  &nbsp; Email</a>';
                            }else if(data == 'print'){
                                data = 'Print Reported<br> <a data-mainid=' + row.id + ' class="act_send btn btn-success btn-sm text-white">Send  &nbsp; Email</a>';
                            }else if(data == 'both'){
                                data = 'Done';
                            }else{
                                data = '<a data-mainid=' + row.id + ' class="act_send btn btn-success btn-sm text-white">Send  &nbsp; Email</a>';
                                data = data  + '<a data-mainid=' + row.id + ' class="act_print btn btn-warning btn-sm text-white">Print Report</a>';
                            }
                            data = '<a href="/techs/' + row.technician_id + '">' + data + '</a>';
                        }
                        return data;
                    }},
                {"data": "id",
                    "render": function(data, type, row){
                        if(type === 'display'){
                            data = '<a href="/maintenances/' + data + '"> <div class="btn-group"> <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"> <i class="fa fa-pencil-alt"></i> </button> </div> </a>';
                        }
                        return data;
                    }},
                {"data": "id",
                    "render": function(data, type, row){
                        if(type === 'display'){
                            data = '<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#delete-modal" data-mainid=' + data + '> <i class="fa fa-times"></i></button>';
                        }
                        return data;
                    }},
            ],
        });
        console.log(table)
    });
</script>
@endsection

@section('content')
<!-- Hero -->
<div class="bg-body-light">

    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 class="flex-sm-fill font-size-h2" style="padding-left: 50px;">All Finished Maintenance Table</h1>
        <a class="block text-center bg-gd-lake" href="javascript:void(0)">
            <div class="block-content block-content-full aspect-ratio-1-1 d-flex justify-content-center align-items-center">

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
            <table id="mytabla" class="data-table mdl-data-table dataTable table table-bordered table-striped table-vcenter js-dataTable-buttons">
                <thead>
                    <tr>
                        <th class="text-center" style="width:10%;">Date</th>
                        <th style="width: 20%;">Job Number</th>
                        <th style="width: 20%;">Job Name</th>
                        <th class="d-none d-sm-table-cell" style="width: 5%;">Maintenance ID</th>
                        <th class="d-none d-sm-table-cell" style="width: 20%;">Job Address</th>
                        <th style="width: 15%;">Group</th>
                        <th style="width: 15%;">Lifts</th>
                        <th style="width: 15%;">Techinician</th>
                        <th style="width: 15%;">Report </th>
                        <th style="width: 15%;">View</th>
                        <th style="width: 15%;">Delete</th>
                    </tr>
                </thead>
                <tbody>
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
                        <h3 class="block-title">Delete Confirmation</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <h1>Are you Sure?</h1>

                        <form method="POST" action="/maintenances/{{isset($maintenance)?$maintenance->id:''}}">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="maintenance_id" id="maintenance_id" value="">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="/maintenances/maintenanceprint" id="print_form">
        @csrf
        <input type="hidden" name="main_id" id="main_print_id" value=""/>
    </form>
    <form method="POST" action="{{url('/maintenances/maintenancesendemail')}}" id="send_form">
        @csrf
        <input type="hidden" name="main_id" id="main_send_id" value=""/>
    </form>


<!-- END Page Content -->
@endsection
