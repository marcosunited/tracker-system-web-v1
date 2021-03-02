<div id="main-navigation" class="d-none d-lg-block push">
    <ul class="nav-main nav-main-horizontal nav-main-hover">
        <li class="nav-main-item">
            <a class="nav-main-link" href="/maintenances/{{$maintenance->id}}">
                <i class="nav-main-link-icon fa fa-phone"></i>
                <span class="nav-main-link-name">Maintenance Details</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="/maintenances/{{$maintenance->id}}/techdetails">
                <i class="nav-main-link-icon fa fa-user-cog"></i>
                <span class="nav-main-link-name">Techinician Details</span>
            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="/maintenances/{{$maintenance->id}}/jobdetails">
                <i class="nav-main-link-icon fa fa-book-open"></i>
                <span class="nav-main-link-name">Job Details</span>
            </a>
        </li>

        <li class="nav-main-item">
            <a class="nav-main-link" href="/maintenances/{{$maintenance->id}}/round">
                <i class="nav-main-link-icon fa fa-flag"></i>
                <span class="nav-main-link-name">Round</span>
            </a>
        </li>

        <li class="nav-main-item">
            <a class="nav-main-link" href="/maintenances/{{$maintenance->id}}/file">
                <i class="nav-main-link-icon fa fa-file"></i>
                <span class="nav-main-link-name">Files</span>

            </a>
        </li>
        <li class="nav-main-item">
            <a class="nav-main-link" href="/maintenances/{{$maintenance->id}}/notes">
                <i class="nav-main-link-icon fa fa-sticky-note"></i>
                <span class="nav-main-link-name">Notes</span>

            </a>
        </li>
        <li class="nav-main-item">
            <div class="btn-group">
                <button type="button" class="btn nav-main-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="nav-main-link-icon fa fa-print"></i>
                    Print
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/maintenances/{{$maintenance->id}}/print" target="_blank">Docket</a>
                    <div class="dropdown-divider"></div>
                    <div class="hidden" id="menu-forms">
                        <a class="dropdown-item" href="/reports/new/custom-report?id={{$maintenance->id}}&name=complianceGenerate" target="_blank">Compliance Certification (v2.2.10)</a>
                        <a class="dropdown-item" href="/reports/new/custom-report?id={{$maintenance->id}}&name=checklistGenerate" target="_blank">Inspection and Test plan (v2.2.10)</a>
                        <a class="dropdown-item" href="/reports/new/custom-report?id={{$maintenance->id}}&name=maintenanceRecordLogGenerate" target="_blank">Schedule Record log (v2.2.10)</a>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
<!-- END Main Navigation -->