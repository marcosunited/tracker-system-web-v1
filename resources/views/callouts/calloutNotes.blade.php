@extends('layouts.backend')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.skinHTML5.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/dropzone/dist/min/dropzone.min.css') }}">
<link rel="stylesheet" href="{{asset('js/plugins/datatables/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css')}}">
@endsection

@section('js_after')
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('js/plugins/dropzone/dropzone.min.js') }}"></script>
<script src="{{asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/buttons/buttons.colVis.min.js')}}"></script>

<!-- Page JS Helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Ion Range Slider + Masked Inputs plugins) -->
<script>jQuery(function(){ Dashmix.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider', 'masked-inputs']); });</script>

<!-- Page JS Code -->
<script src="{{asset('js/pages/be_tables_datatables.min.js')}}"></script>
@endsection

@section('content')
@include('error.error')
<div class="bg-white inner-top-bar">
    <div class="content">
        <!-- Toggle Main Navigation -->

        <!-- END Toggle Main Navigation -->

        <!-- Main Navigation -->
        @include('layouts.innerCalloutNav')
        <!-- END Main Navigation -->
    </div>
</div>
<!-- Page Content -->

<div class="content">
    <!-- Discussion -->
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Notes for Callout ID {{$callout->id}} {{$callout->jobs->job_name}}</h3>
            <div class="block-options">
                <button type="button" class="btn btn-hero-primary" data-toggle="modal" data-target="#callout_notes">Add
                    Notes</button>
            </div>
        </div>
        <div class="block-content">
            @if(count($notes))
            @foreach($notes as $note)
            <div class="col-md-6">
                <div class="block block-themed">
                    <div class="block-header">
                        <h3 class="block-title">{{$note->created_at}}</h3>
                        <div style="float:right">{{$note->users->name}}</div>
                        <div class="block-options">
                            <form method="POST" action="/callouts/{{$callout->id}}/notes/{{$note->id}}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete"
                                    style="float:right">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="block-content">
                        <p class="font-size-sm text-muted">{{$note->description}}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <!-- END Discussion -->
</div>

<div class="modal" id="callout_notes" tabindex="-1" role="dialog" aria-labelledby="callout_notes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Add Notes For {{$callout->jobs->job_name}}</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <form action="/callouts/{{$callout->id}}/notes" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="example-text-input">Notes Description</label>
                            <textarea class="form-control" rows="3" placeholder="" name="description" required></textarea>
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
    <!-- END Page Content -->
    @endsection
