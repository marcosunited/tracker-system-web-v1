
<div id="main-navigation" class="d-none d-lg-block push">
    <ul class="nav-main nav-main-horizontal nav-main-hover">
        <li class="nav-main-item">
            <a class="nav-main-link" href="/repairs/{{$repair->id}}">
                <i class="nav-main-link-icon fa fa-phone"></i>
                <span class="nav-main-link-name">Repair Details</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="/repairs/{{$repair->id}}/techdetails">
                <i class="nav-main-link-icon fa fa-user-cog"></i>
                <span class="nav-main-link-name">Techinician Details</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="/repairs/{{$repair->id}}/jobdetails">
                <i class="nav-main-link-icon fa fa-book-open"></i>
                <span class="nav-main-link-name">Job Details</span>
            </a>
        </li>
        
        <li class="nav-main-item">
            <a class="nav-main-link"
                href="/repairs/{{$repair->id}}/round">
                <i class="nav-main-link-icon fa fa-flag"></i>
                <span class="nav-main-link-name">Round</span>
            </a>
        </li>
        
        <li class="nav-main-item">
            <a class="nav-main-link" href="/repairs/{{$repair->id}}/file">
                <i class="nav-main-link-icon fa fa-file"></i>
                <span class="nav-main-link-name">Files</span>
                <span class="nav-main-link-badge badge badge-pill badge-success">{{count($repair->files)}}</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="/repairs/{{$repair->id}}/notes">
                <i class="nav-main-link-icon fa fa-sticky-note"></i>
                <span class="nav-main-link-name">Notes</span>
                <span class="nav-main-link-badge badge badge-pill badge-success">{{count($repair->notes)}}</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link"
            href="/repairs/{{$repair->id}}/print">
                <i class="nav-main-link-icon fa fa-print"></i>
                <span class="nav-main-link-name">Print</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link"  href="#">
                <i class="nav-main-link-icon fa fa-file-invoice-dollar"></i>
                <span class="nav-main-link-name">Invoice</span>
            </a>
        </li>      
    </ul>
</div>
<!-- END Main Navigation -->