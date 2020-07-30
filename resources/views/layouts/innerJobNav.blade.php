
<div id="main-navigation" class="d-none d-lg-block push">
    <ul class="nav-main nav-main-horizontal nav-main-hover">
        <li class="nav-main-item">
            <a class="nav-main-link" href="/jobs/{{$job->id}}">
                <i class="nav-main-link-icon fa fa-list-alt"></i>
                <span class="nav-main-link-name">Job Details</span>
            </a>
        </li>
        <li class="nav-main-heading">Manage</li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="/jobs/{{$job->id}}/lifts">
                <i class="nav-main-link-icon fa fa-angle-double-up"></i>
                <span class="nav-main-link-name">Lifts</span>
                <span class="nav-main-link-badge badge badge-pill badge-success">{{count($job->lifts)}}</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" aria-haspopup="true" aria-expanded="false"
                href="/jobs/{{$job->id}}/callouts">
                <i class="nav-main-link-icon fa fa-phone"></i>
                <span class="nav-main-link-name">Callouts</span>
                <span class="nav-main-link-badge badge badge-pill badge-success">{{count($job->callouts)}}</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" aria-haspopup="true" aria-expanded="false"
                href="/jobs/{{$job->id}}/maintenances">
                <i class="nav-main-link-icon fa fa-tools"></i>
                <span class="nav-main-link-name">Maintenance</span>
                <span class="nav-main-link-badge badge badge-pill badge-success">{{count($job->maintenances)}}</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link"  aria-haspopup="true" aria-expanded="false"
            href="/jobs/{{$job->id}}/repairs">
                <i class="nav-main-link-icon fa fa-cogs"></i>
                <span class="nav-main-link-name">Repairs</span>
                <span class="nav-main-link-badge badge badge-pill badge-success">{{count($job->repairs)}}</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" aria-haspopup="true" aria-expanded="false"
            href="/jobs/{{$job->id}}/rounds">
                <i class="nav-main-link-icon fa fa-flag"></i>
                <span class="nav-main-link-name">Round</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false"
                href="#">
                <i class="nav-main-link-icon fa fa-table"></i>
                <span class="nav-main-link-name">Schedule</span>
            </a>
            <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="">
                        <span class="nav-main-link-name">Table</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="#">
                <i class="nav-main-link-icon fa fa-file-alt"></i>
                <span class="nav-main-link-name">Reports</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="#">
                <i class="nav-main-link-icon fa fa-file-invoice-dollar"></i>
                <span class="nav-main-link-name">Invoice</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="/jobs/{{$job->id}}/file">
                <i class="nav-main-link-icon fa fa-file"></i>
                <span class="nav-main-link-name">Files</span>
                <span class="nav-main-link-badge badge badge-pill badge-success">{{count($job->files)}}</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="/jobs/{{$job->id}}/notes">
                <i class="nav-main-link-icon fa fa-sticky-note"></i>
                <span class="nav-main-link-name">Notes</span>
                <span class="nav-main-link-badge badge badge-pill badge-success">{{count($job->notes)}}</span>
            </a>
        </li>
    </ul>
</div>
<!-- END Main Navigation -->