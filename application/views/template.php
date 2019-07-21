<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>C Rapor</title>

    <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.png') ?>" type="image/x-icon">
    
    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets') ?>/css/animate.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets') ?>/css/sb-admin-2.css" rel="stylesheet">


    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/style.css">
    <!-- Custom styles for this page -->
    <link href="<?= base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/select2/css/select2.min.css">
     
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/select2-bootstrap4.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    
    <script src="<?= base_url('assets') ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendor/jquery-ui/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/loader2.css">
    <script src="<?= base_url('assets') ?>/js/pace.min.js"></script>

    <script src="<?= base_url() ?>assets/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>
    <!-- sweetalert -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/sweetalert2/sweetalert2.min.css">
</head>

<body id="page-top">
    <?php
    $user = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row();
    ?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <img src="<?= base_url('assets/img/logo1.png') ?>" style="max-width:50px">
                </div>
                <div class="sidebar-brand-text mx-3">C -Rapor </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Navigasi Utama
            </div>
            <!-- area menu dinamis -->
            <?php 
            $role = $this->session->userdata('role_id');
            $main_menu = $this->db->get_where('menus', ['is_main_menu' => 0, 'role' => $role])->result();
            foreach ($main_menu as $main) {
                $submenu = $this->db->get_where('menus', ['is_main_menu' => $main->id]);
                if ($submenu->num_rows() > 0) {
                    echo
                        '<li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#' . $main->link . '" aria-expanded="true" aria-controls="collapseTwo">
                            <i class="' . $main->icon . '"></i>
                            <span>' . $main->title . '</span>
                        </a>
                        <div id="' . $main->link . '" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">';

                    foreach ($submenu->result() as $sub) {
                        echo
                            '<a class="collapse-item" href="'.base_url() . $sub->link . '">
                                <i class="' . $sub->icon . '"></i> ' . $sub->title . '
                            </a>';
                    }
                    echo
                        '</div>
                        </div>
                        </li>';
                } else {
                    echo '<li class ="nav-item ">
                            <a class="nav-link" href="'.base_url(). $main->link . '">
                                <i class="' . $main->icon . '" ></i>
                                <span>' . $main->title . '</span>
                            </a>
                         </li>';
                }
            }
            ?>
            <?php 
            $myinfo = get_my_info();
            $cek = $this->db->get_where('kelas',['guru_id' => $myinfo->id])->num_rows();
            if($cek): ?>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                 Navigasi Wali Kelas
            </div>
            <?php 
            $main_menu = $this->db->get_where('menus', ['is_main_menu' => 0, 'role' => 3])->result();
            foreach ($main_menu as $main) {
                $submenu = $this->db->get_where('menus', ['is_main_menu' => $main->id]);
                if ($submenu->num_rows() > 0) {
                    echo
                        '<li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#' . $main->link . '" aria-expanded="true" aria-controls="collapseTwo">
                            <i class="' . $main->icon . '"></i>
                            <span>' . $main->title . '</span>
                        </a>
                        <div id="' . $main->link . '" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">';

                    foreach ($submenu->result() as $sub) {
                        echo
                            '<a class="collapse-item" href="'.base_url() . $sub->link . '">
                                <i class="' . $sub->icon . '"></i> ' . $sub->title . '
                            </a>';
                    }
                    echo
                        '</div>
                        </div>
                        </li>';
                } else {
                    echo '<li class ="nav-item ">
                            <a class="nav-link" href="'.base_url(). $main->link . '">
                                <i class="' . $main->icon . '" ></i>
                                <span>' . $main->title . '</span>
                            </a>
                         </li>';
                }
            }
            ?>
            <?php endif; ?>
            <?php 
            $cek2 = $this->db->get_where('role_khusus',['guru_id' => $myinfo->id])->num_rows();
            if($cek2): ?>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                 Navigasi role khusus
            </div>
            <?php 
            $main_menu = $this->db->get_where('menus', ['is_main_menu' => 0, 'role' => 4])->result();
            foreach ($main_menu as $main) {
                $submenu = $this->db->get_where('menus', ['is_main_menu' => $main->id]);
                if ($submenu->num_rows() > 0) {
                    echo
                        '<li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#' . $main->link . '" aria-expanded="true" aria-controls="collapseTwo">
                            <i class="' . $main->icon . '"></i>
                            <span>' . $main->title . '</span>
                        </a>
                        <div id="' . $main->link . '" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">';

                    foreach ($submenu->result() as $sub) {
                        echo
                            '<a class="collapse-item" href="'.base_url() . $sub->link . '">
                                <i class="' . $sub->icon . '"></i> ' . $sub->title . '
                            </a>';
                    }
                    echo
                        '</div>
                        </div>
                        </li>';
                } else {
                    echo '<li class ="nav-item ">
                            <a class="nav-link" href="'.base_url(). $main->link . '">
                                <i class="' . $main->icon . '" ></i>
                                <span>' . $main->title . '</span>
                            </a>
                         </li>';
                }
            }
            ?>
            <?php endif; ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow mx-1">
                          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter">3+</span>
                          </a>
                          <!-- Dropdown - Alerts -->
                          <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header bg-info border-info">
                              Alerts Center
                            </h6>
                            <?php $alerts = $this->db->get_where('notif',['showed' => 1])->result();
                            if($alerts):
                            foreach($alerts as $a): ?>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                              <div class="mr-3">
                                <div class="icon-circle <?= $a->bg ?>">
                                  <i class="<?= $a->icon ?> text-white"></i>
                                </div>
                              </div>
                              <div>
                                <div class="small text-gray-500"><?= $a->time ?></div>
                                <span class="font-weight-bold"><?= $a->notif ?></span>
                              </div>
                            </a>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                              <div class="mr-3">
                                <div class="icon-circle bg-info">
                                  <i class="fas fa-laugh-wink text-white"></i>
                                </div>
                              </div>
                              <div>
                                <div class="small text-gray-500">Administrator</div>
                                <span class="font-weight-bold">Tidak ada notifikasi ditampilkan untuk saat ini</span>
                              </div>
                            </a>
                            <?php endif ?>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Remember these alert</a>
                          </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user->name ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url('assets/img/profile/'.$user->image) ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('user/profile') ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="<?= base_url('user/activity/'.$user->slug) ?>">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <?= $content_view; ?>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; 2019 Crapor | Page load on <strong>{elapsed_time}</strong> second</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-info" href="<?= base_url('auth/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_content" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
           
        </div>
    </div>
    <div id="loading">
    <div class="lds-dual-ring"></div>
    </div>

    

    

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets') ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets') ?>/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('assets') ?>/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/jquery.ui.widget.js"></script>
    <script src="<?= base_url('assets') ?>/js/jquery.fileupload.js"></script>
    <!-- Page for select2 -->
    <script src="<?= base_url('assets/') ?>vendor/select2/js/select2.min.js"></script>
    <script src="<?= base_url('assets/')?>vendor/sweetalert2/sweetalert2.min.js"></script>

    <script src="<?= base_url('assets/') ?>/js/scripts.js"></script>