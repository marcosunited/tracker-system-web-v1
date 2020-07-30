@extends('layouts.simple')

@section('content')
<div id="page-container">

<!-- Main Container -->
<main id="main-container">

    <!-- Page Content -->
    <div class="bg-image" style="background-image: url('{{ asset('media/photos/photo19@2x.jpg') }}');">
        <div class="row no-gutters justify-content-center bg-primary-dark-op">
            <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                <!-- Sign In Block -->
                <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                    <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-white">
                        <!-- Header -->
                        <div class="mb-2 text-center">
                            <img src="http://cloud.unitedlifts.com.au/melbourne-tracker/app/images/logo.png" style="margin:10px">
                            <p class="text-uppercase font-w700 font-size-sm text-muted">Sign In</p>
                        </div>
                        <!-- END Header -->

                        <!-- Sign In Form -->
                        <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js) -->
                        <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <form method="POST" action="{{ route('login') }}">
                        @csrf
                            <div class="form-group">
                                <div class="input-group">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-user-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  placeholder="Password">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-asterisk"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-hero-primary">
                                    <i class="fa fa-fw fa-sign-in-alt mr-1"></i> {{ __('Login') }}
                                </button>
                            </div>
                        </form>
                        <!-- END Sign In Form -->
                        <div class="mb-2 text-center">
                        <p class="text-uppercase font-w700 font-size-sm text-muted">Version 1.2</p>
                        </div>
                    </div>
                    <div class="block-content bg-body">
                        <div class="d-flex justify-content-center text-center push">
                            <a class="item item-circle item-tiny mr-1 bg-default" href="#"></a>
                    </div>
                    </div>
                </div>
                <!-- END Sign In Block -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->

</main>
<!-- END Main Container -->
</div>
@endsection
