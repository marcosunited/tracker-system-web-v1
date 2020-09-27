        <!-- Side Overlay-->
        <aside id="side-overlay">
            <!-- Side Header -->
            <div class="bg-image" style="background-image: url('{{ asset('media/various/bg_side_overlay_header.jpg') }}')">
                <div class="bg-primary-op">
                    <div class="content-header">
                        <!-- User Avatar -->
                        <!-- END User Avatar -->

                        <!-- User Info -->
                        <div class="ml-2">
                            <a class="text-white font-w600" href="javascript:void(0)">Callouts Notification</a>
                        </div>
                        <!-- END User Info -->

                        <!-- Close Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a class="ml-auto text-white" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                            <i class="fa fa-times-circle"></i>
                        </a>
                        <!-- END Close Side Overlay -->
                    </div>
                </div>
            </div>
            <!-- END Side Header -->

            <!-- Side Content -->
            <div class="content-side">
                @if (count($alarms['week']) > 0 )
                <div class="block block-transparent pull-x pull-t">
                    <div class="block-content block-content-sm block-content-full bg-body">
                        <span class="text-uppercase font-size-sm font-w700"> Week Period <br> {{ date('Y-m-d',strtotime($alarms['start_week']))}} ~ {{ date('Y-m-d', strtotime($alarms['end_week']))}} </span>
                        <span class="text-uppercase font-size-sm font-w700"> Callouts : {{count($alarms['week'])}} </span>
                    </div>
                    @foreach ($alarms['week'] as $week )
                    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                            <div class="mr-3">
                                <p class=" mb-0">
                                    {{$week['callout']->job_name}}
                                </p>
                                <p class="text-muted mb-0">
                                    Lift Names:
                                    @foreach ($week['lift'] as $lift)
                                    @if(isset($lift->lift_name))
                                    {{$lift->lift_name}},
                                    @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="item item-circle bg-body-light">
                                <a href="javascript:void(0)" class="remove_notify"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @endif
                @if (count($alarms['month']) > 0 )
                <div class="block block-transparent pull-x pull-t">
                    <div class="block-content block-content-sm block-content-full bg-body">
                        <span class="text-uppercase font-size-sm font-w700"> Month Period <br> {{ date('Y-m-d',strtotime($alarms['start_month']))}} ~ {{ date('Y-m-d', strtotime($alarms['end_month']))}} </span>
                        <span class="text-uppercase font-size-sm font-w700"> Callouts : {{count($alarms['month'])}} </span>
                    </div>
                    @foreach ($alarms['month'] as $month )
                    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                            <div class="mr-3">
                                @if(isset($week))
                                <p class=" mb-0">
                                    {{$week['callout']->job_name}}

                                </p>
                                <p class="text-muted mb-0">
                                    Lift Names:

                                    @foreach ($week['lift'] as $lift)
                                    @if(isset($lift->lift_name))
                                    {{$lift->lift_name}},
                                    @endif
                                    @endforeach
                                </p>
                                @endif
                            </div>
                            <div class="item item-circle bg-body-light">
                                <a href="javascript:void(0)" class="remove_notify"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
            <!-- END Side Content -->
        </aside>
        <!-- END Side Overlay -->