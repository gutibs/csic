<nav class="navbar navbar-top fixed-top navbar-expand" id="navbarDefault">
    <div class="collapse navbar-collapse justify-content-between">
        <div class="navbar-logo">

            <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
            <a class="navbar-brand me-1 me-sm-3" href="#">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center"><img src="../static/imagenes/66_CSIC.jpg" alt="" width="127" /></div>
                </div>
            </a>
        </div>

        <ul class="navbar-nav navbar-nav-icons flex-row">
            <li class="nav-item">
                <div class="theme-control-toggle fa-icon-wait px-2">
                    <input class="form-check-input ms-0 theme-control-toggle-input" type="checkbox" data-theme-control="phoenixTheme" value="dark" id="themeControlToggle" />
                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Cambiar modo" style="height:32px;width:32px;"><span class="icon" data-feather="moon"></span></label>
                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Cambiar modo" style="height:32px;width:32px;"><span class="icon" data-feather="sun"></span></label>
                </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                    <span class="fs-4 lh-1 uil uil-bright text-success-dark"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border" aria-labelledby="navbarDropdownUser">
                    <div class="card position-relative border-0">
                        <div class="card-body p-0">
                            <div class="text-center pt-4 pb-3">
                                <span class="fs-4 lh-1 uil uil-bright text-success-dark"></span>
                                <h6 class="mt-2 text-body-emphasis"><?php echo ucfirst($_SESSION['nombre']);?></h6>
                            </div>
                        </div>
                        <div class="card-footer p-0 border-top border-translucent">
                            <div class="px-3"> <a class="btn btn-phoenix-secondary d-flex flex-center w-100" href="../logout.php"> <span class="me-2" data-feather="log-out"> </span>Salir</a></div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>