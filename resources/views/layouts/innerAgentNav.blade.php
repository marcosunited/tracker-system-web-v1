
<div id="main-navigation" class="d-none d-lg-block push">
    <ul class="nav-main nav-main-horizontal nav-main-hover">
        <li class="nav-main-item">
            <a class="nav-main-link" href="/agents/{{$agent->id}}">
                <i class="nav-main-link-icon fa fa-list-alt"></i>
                <span class="nav-main-link-name">Agent Details</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="/agents/{{$agent->id}}/jobs">
                <i class="nav-main-link-icon fa fa-book-open"></i>
                <span class="nav-main-link-name">Jobs</span>
                <span class="nav-main-link-badge badge badge-pill badge-success">{{count($agent->jobs)}}</span>
            </a>
        </li>
    </ul>
</div>
<!-- END Main Navigation -->