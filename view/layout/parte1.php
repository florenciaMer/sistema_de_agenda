<?php 

session_start();
if(isset($_SESSION['sesion_email'])){
//echo "el user paso por el login";

$email_sesion = $_SESSION['sesion_email'];

$query_sesion = $pdo->prepare("SELECT * FROM `tb_usuarios` WHERE email = '$email_sesion' AND estado = '1'");
$query_sesion->execute();
$sesion_usuario = $query_sesion->fetchAll(PDO::FETCH_ASSOC);
  foreach ($sesion_usuario as $dato_usuario) {
    $id_usuario = $dato_usuario['id_usuario'];
    $email = $dato_usuario['email'];
    
  }
}else{
  
  session_start();
    $_SESSION['mensaje'] = 'Para ingresar debe loguearse o registrarse';
    $_SESSION['icono'] = 'success';
  header('Location:'.APP_URL."/view/login/index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo APP_NAME;?></title>

  <!-- jQuery -->
  <script src="<?php echo APP_URL;?>/public/adminLTE/plugins/jquery/jquery.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-treetable/3.2.0/jquery.treetable.js" integrity="sha512-F6hdKRCotYvOPb0/9pbeJWlql7NA3R9h3K/uQnAeKoI8jy477dtZ7tgPq4EeQfAeJHxVv8HywXxmTTA2LRKcrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-treetable/3.2.0/css/jquery.treetable.css" integrity="sha512-l1bJ1VnsPD+m5ZYhfcl9PrJgbCQixXtQ/zs423QYu0w1xDGXJOSC0TmorOocaYY8md5+YMRcxZ/UgjyOSIlTYw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-treetable/3.2.0/css/jquery.treetable.theme.default.css" integrity="sha512-S0Z8qdW2IlHsTsra73PQ9cTRAFIugG853UK9hkv6CZ/H6MemHuZokEQKhjtvQEQ1NpQuaheq1wcGcrY46PK9og==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  
  
  
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo APP_URL;?>/public/adminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo APP_URL;?>/public/adminLTE/dist/css/adminlte.min.css">
  
  <link href="
  https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css
  " rel="stylesheet">
  <script src="
  https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js
  "></script>
  
  
  
  <!--iconos de bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" integrity="sha512-A81ejcgve91dAWmCGseS60zjrAdohm7PTcAjjiDWtw3Tcj91PNMa1gJ/ImrhG+DbT5V+JQ5r26KT5+kgdVTb5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <!-- data tables-->
<link rel="stylesheet" href="<?php echo APP_URL;?>/public/adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo APP_URL;?>/public/adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo APP_URL;?>/public/adminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- data tables-->


</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo APP_URL;?>/index.php" class="nav-link"><?php echo APP_NAME;?></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
       
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="<?php echo APP_URL;?>/public/img/calendario.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <a href="<?php echo APP_URL;?>/index.php" class="brand-text font-weight-light"><h3>SIS | Agenda</h3></a>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo APP_URL;?>/public/img/usuario.png" class="elevation-2" alt="usuario">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['sesion_email'];?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

           <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon bi bi-person"></i>
              <p>
                Usuarios
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo APP_URL;?>/view/usuarios/index.php" class="nav-link">
                <i class="nav-icon bi bi-person"></i>
                  <p>Listado de Usuarios</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo APP_URL;?>/view/pacientes/index.php" class="nav-link active">
              <i class="nav-icon bi-emoji-astonished"></i>
              <p>
                Pacientes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo APP_URL;?>/view/pacientes/index.php" class="nav-link">
                <i class="nav-icon bi-emoji-astonished"></i>
                  <p>Listado de Pacientes</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="<?php echo APP_URL;?>/view/valores/index.php" class="nav-link active">
              <i class="nav-icon bi bi-cash-coin"></i>
              <p>
                Valores Consultas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo APP_URL;?>/view/valores/index.php" class="nav-link">
                <i class="nav-icon bi bi-cash-coin"></i>
                  <p>Listado de Valores</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item" style="background-color:red; color:white; border-radius:6px">
            <a href="<?php echo APP_URL;?>/controllers/login/logout.php" class="nav-link">
              <i class="nav-icon bi bi-door-open"></i>
              <p>
                Cerrar sesión
              </p>
            </a>
          </li>
        </ul>
      </nav>
      
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
