@extends('layouts.simple')

@section('content')
<div id="page-container">

            <!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                <div class="bg-image" style="background-image: url('assets/media/photos/photo14@2x.jpg');">
                    <div class="row no-gutters justify-content-center bg-black-75">
                        <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                            <!-- Sign Up Block -->
                            <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                                <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-white inner-top-bar">
                                    <!-- Header -->
                                    <div class="mb-2 text-center">
                                        <a class="link-fx text-success font-w700 font-size-h1" href="index.html">
                                            <span class="text-dark">UnitedLifts</span><span class="text-primary">Services</span>
                                        </a>
                                        <p class="text-uppercase font-w700 font-size-sm text-muted">Create New Account</p>
                                    </div>
                                    <!-- END Header -->

                                    <!-- Sign Up Form -->
                                    <!-- jQuery Validation (.js-validation-signup class is initialized in js/pages/op_auth_signup.min.js which was auto compiled from _es6/pages/op_auth_signup.js) -->
                                    <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                    <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                        <div class="form-group">
                                            <div class="input-group">
                                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="Username">

                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('name') }}</strong>
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
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email">

                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="fa fa-envelope-open"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

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
                                            <a class="font-w600 font-size-sm" href="#" data-toggle="modal" data-target="#modal-terms">Terms &amp; Conditions</a>
                                            <div class="custom-control custom-checkbox custom-control-primary">
                                                <input type="checkbox" class="custom-control-input" id="signup-terms" name="signup-terms">
                                                <label class="custom-control-label" for="signup-terms">I agree</label>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-hero-primary">
                                                <i class="fa fa-fw fa-plus mr-1"></i>  {{ __('Register') }}
                                            </button>
                                        </div>
                                    </form>
                                    <!-- END Sign Up Form -->
                                </div>
                            </div>
                        </div>
                        <!-- END Sign Up Block -->
                    </div>
                </div>
                <!-- END Page Content -->

            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->
@endsection
