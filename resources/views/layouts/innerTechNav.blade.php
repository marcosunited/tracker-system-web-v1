
<div id="main-navigation" class="d-none d-lg-block push">
    <ul class="nav-main nav-main-horizontal nav-main-hover">
        <li class="nav-main-item">
            <a class="nav-main-link" href="/techs/{{$tech->id}}">
                <i class="nav-main-link-icon fa fa-list-alt"></i>
                <span class="nav-main-link-name">Technician Details</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="/techs/{{$tech->id}}/jobs">
                <i class="nav-main-link-icon fa fa-book-open"></i>
                <span class="nav-main-link-name">Jobs</span>
                <span class="nav-main-link-badge badge badge-pill badge-success">{{count($tech->rounds->jobs)}}</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link"
            href="/techs/{{$tech->id}}/callouts">
                <i class="nav-main-link-icon fa fa-phone"></i>
                <span class="nav-main-link-name">Callouts</span>
                <span class="nav-main-link-badge badge badge-pill badge-success">{{count($tech->callouts)}}</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link"
            href="/techs/{{$tech->id}}/maintenances">
                <i class="nav-main-link-icon fa fa-tools"></i>
                <span class="nav-main-link-name">Maintenance</span>
                <span class="nav-main-link-badge badge badge-pill badge-success">{{count($tech->maintenances)}}</span>
            </a>
        </li>
    </ul>
</div>
<!-- END Main Navigation -->