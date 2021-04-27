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
<script type="text/javascript">
    function onOpenLift(url) {
        window.open(url, '_blank');
    }

    $(document).ready(function() {
        $('#delete-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var liftId = button.data('liftid')
            $(this).find('.modal-content #lift_id').val(liftId);
        })
    });
</script>
@endsection

@section('content')
@include('error.error')
<div class="bg-white">
    <div class="content">
        <!-- Toggle Main Navigation -->

        <!-- END Toggle Main Navigation -->

        <!-- Main Navigation -->
        @include('layouts.innerJobNav')
        <!-- END Main Navigation -->
    </div>
</div>
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <span class="badge badge-pill badge-success">View:</span>&nbsp&nbsp<h3 class="block-title">{{$job->job_name}}</h3>
            <button type="button" class="btn btn-hero-primary" data-toggle="modal" data-target="#modal-block-vcenter">Add
                Lift</button>
        </div>

        <div class="block-content">

            <div class="row push">
                <div class="col-lg-6">

                    @if(count($lifts))
                    @foreach($lifts as $lift)

                    <div class="block block-themed bg-image" style="background-image: url('/media/photos/photo19.jpg');">
                        <div class="block-header block-header-default bg-primary-dark-op bg-image">

                            <h3 class="block-title" onclick="onOpenLift('/jobs/{{$job->id}}/lifts/{{$lift->id}}')">{{$lift->lift_name}}</h3>
                            <div class="block-options">
                                <div class="block-options-item">
                                    <span class="badge badge-secondary">{{$lift->zone}}</span>
                                </div>
                                <div class="block-options-item">
                                    <span class="badge badge-success">{{$lift->lift_status_id == 1 ? 'Active': 'Inactive'}}</span>
                                </div>
                                <div class="block-options-item">
                                    <span class="badge badge-warning">{{$lift->capacity.' KG'}}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="block-options">
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal" data-liftid={{$lift->id}}>Delete</button>
                            </div>
                        </div>
                        <div class="block-content bg-white">
                            {{$lift->lift_brand}}
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Normal Block Modal -->
    <div class="modal" id="modal-block-vcenter" tabindex="-1" role="dialog" aria-labelledby="modal-block-vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Add Lifts For {{$job->job_name}}</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="/jobs/{{$job->id}}/lifts" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="example-text-input">Lift Status</label>
                                <select class="form-control" name="lift_status_id" required>
                                    <option value="">--- Select Status ---</option>
                                    <option value="1" name="lift_status_id">Active</option>
                                    <option value="2" name="lift_status_id">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Lift Type</label>
                                <select class="form-control" name="lift_type" required>
                                    <option value="">--- Select Type ---</option>
                                    <option value="L" name="lift_type">Lifts</option>
                                    <option value="E" name="lift_type">Escalators</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Lift name</label>
                                <input type="text" class="form-control" name="lift_name" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Lift Phone</label>
                                <input type="text" class="form-control" name="lift_phone" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Lift Register Number</label>
                                <input type="text" class="form-control" name="lift_reg_number" placeholder="" required>
                            </div>
                            <div class="block-content block-content-full text-right bg-light">
                                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Normal Block Modal -->
    </div>

    <!-- Modal delete -->
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

                        <form action="/lifts" method="POST">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="lift_id" id="lift_id" value="">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection