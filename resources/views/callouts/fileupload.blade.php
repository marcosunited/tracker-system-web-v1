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
    <!-- Dropzone (functionality is auto initialized by the plugin itself in js/plugins/dropzone/dropzone.min.js) -->
    <!-- For more info and examples you can check out http://www.dropzonejs.com/#usage -->
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Dropzone</h3>
        </div>
        <div class="block-content block-content-full">
            <h2 class="content-heading">Callout File Uploads</h2>
            <div class="row">
                <div class="col-lg-4">
                    <p class="text-muted">
                        Drag and drop sections for your file uploads
                    </p>
                </div>
                <div class="col-lg-8 col-xl-5">
                    <!-- DropzoneJS Container -->
                    <form class="dropzone" action="/callouts/{{$callout->id}}/file" id="my-awesome-dropzone" method="post"
                        enctype="mulipart/form-data">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END Dropzone -->
    <div class="block block-rounded block-bordered">
        <div class="block-content block-content-full">
        <div class="block-header block-header-default">
            <h3 class="block-title">Files for Callout ID {{$callout->id}} {{$callout->jobs->job_name}}</h3>
        </div>
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width:10%;">Time</th>
                        <th style="width: 20%;">File Name</th>
                        <th style="width: 15%;">View</th>
                        <th style="width: 15%;">Download</th>
                        <th style="width: 15%;">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($callout->files as $file)
                    <tr>
                        <td class="text-center">
                        {{$file->created_at}}
                        </td>
                        <td class="font-w600">
                            {{$file->title}}
                        </td>
                       
                        <td>
                            <a href="/callouts/{{$file->title}}">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="View">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </div>
                            </a>
                        </td>
                        <td>
                        <a href="/callouts/{{$file->title}}">
                                 <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Download">
                                        <i class="fa fa-download"></i>
                                    </button>
                                </div>
</a>
                        </td>
                        <td>
                        <form method="POST" action="/callouts/{{$callout->id}}/file/{{$file->id}}">
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
</div>

<!-- END Page Content -->
@endsection
