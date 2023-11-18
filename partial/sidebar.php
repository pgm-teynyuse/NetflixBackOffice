<div class="d-flex sticky-top flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
    <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-5 d-none font-weight-bold text-uppercase d-sm-inline">
        <h3 class="text-lg"></i>Netflix Backoffice</h3>
    </span>
    </a>
    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
        <li class="nav-item">
            <a href="/" class="nav-link align-middle px-0 text-white">
                <i class="fs-4 fa fa-fw fa-house"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="/User/users.php" class="nav-link align-middle px-0 text-white">
                <i class="fs-4 fa fa-fw fa-users"></i> <span class="ms-1 d-none d-sm-inline">Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="/Media/media.php" class="nav-link align-middle px-0 text-white">
                <i class="fs-4 fa fa-fw fa-video"></i> <span class="ms-1 d-none d-sm-inline">Media Library</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="/Actor/actors.php" class="nav-link align-middle px-0 text-white">
                <i class="fs-4 fa fa-fw fa-star"></i> <span class="ms-1 d-none d-sm-inline">Actors</span>
            </a>
        </li>
    </ul>
    <div class="dropdown pb-4">
        <a href="/login.php" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://avatars.githubusercontent.com/u/113594024?v=4" alt="user" width="30" height="30" class="rounded-circle">
            <span class="d-none d-sm-inline mx-1">Admin</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
    </div>
</div>