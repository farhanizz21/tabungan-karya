<style>
.sidebar-brand {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 15px;
    text-decoration: none;
}

.sidebar-brand-icon {
    display: flex;
    align-items: center;
    justify-content: center;
}

.sidebar-logo {
    height: 50px;
    /* Sesuaikan ukuran agar tidak terlalu besar */
    max-width: 100%;
}

.sidebar-brand-text {
    font-size: 18px;
    font-weight: bold;
    color: #fff;
    /* Sesuaikan warna teks agar kontras */
    white-space: nowrap;
    /* Cegah teks terpotong */
}
</style>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url('assets/img/Logo_Smartedu.svg') ?>" alt="Smart Edu Logo" class="sidebar-logo">
        </div>
        <div class="sidebar-brand-text mx-2">Smart Edu</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item ">
        <a class="nav-link" href="<?= base_url()?>">
            <i class="fas fa-fw fa-tachometer-alt"> </i>
            <span>Dashboard</span></a>
    </li>

    <!-- <li class="nav-item">
        <a class="nav-link" href="<?= base_url('panduan')?>">
            <i class="fas fa-fw fa-book"> </i>
            <span>Panduan</span></a>
    </li> -->
    <?php if($this->session->userdata('role') == 1){?>
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= $active_nav == 'guru' | $active_nav == 'admin' ?'active':'';?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-database"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseTwo" class="collapse <?= $active_nav == 'guru' | $active_nav == 'admin' ?'show':'';?>"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item <?= $active_nav == 'admin' ? 'active':'';?>" href="<?= base_url('admin')?>">Data
                    Admin</a>
                <a class="collapse-item <?= $active_nav == 'guru' ? 'active':'';?>" href="<?= base_url('guru')?>">Data
                    Guru</a>
            </div>
        </div>
    </li>
    <?php } ?>
    <hr class="sidebar-divider">
    <li class="nav-item <?= $active_nav == 'karya' ? 'active':'';?>">
        <a class="nav-link" href="<?= base_url('karya')?>">
            <i class="fas fa-fw fa-file-alt"> </i>
            <span>Karya</span></a>
    </li>
    <li class="nav-item <?= $active_nav == 'karyaku' ? 'active':'';?>">
        <a class="nav-link" href="<?= base_url('karyaku')?>">
            <i class="fas fa-fw fa-file-alt"> </i>
            <span>Karya-Ku</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
                Addons
            </div> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                    aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse show" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item active" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li> -->

    <!-- Nav Item - Charts -->
    <!-- <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li> -->

    <!-- Nav Item - Tables -->
    <!-- <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li> -->

    <!-- Divider -->
    <!-- <hr class="sidebar-divider d-none d-md-block"> -->

    <!-- Sidebar Toggler (Sidebar) -->
    <!-- <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div> -->

</ul>
<!-- End of Sidebar -->