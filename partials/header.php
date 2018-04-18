<?
  include_once $_SESSION['base_url'].'/class/system.php';
  include_once $_SESSION['base_url'].'/helpers/view_functions.php';

  System::validar_logueo();
  
  $system = new System; 
?>
<!doctype html>
<html class="fixed">
  <head>
    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Movimiento Somos Venezuela</title>
    <meta name="keywords" content="HTML5 Admin Template" />
    <meta name="description" content="Porto Admin - Responsive HTML5 Template">
    <meta name="author" content="okler.net">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'assets/vendor/bootstrap/css/bootstrap.css' ?>" />
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'assets/vendor/font-awesome/css/font-awesome.css' ?>" />
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'assets/vendor/magnific-popup/magnific-popup.css' ?>" />
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'assets/vendor/bootstrap-datepicker/css/datepicker3.css' ?>" />

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'assets/vendor/select2/select2.css' ?>" />
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'assets/vendor/jquery-datatables-bs3/assets/css/datatables.css' ?>" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'assets/stylesheets/theme.css' ?>" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'assets/stylesheets/skins/default.css' ?>" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'assets/stylesheets/theme-custom.css' ?>">

    <!-- Head Libs -->
    <script src="<?= $_SESSION['base_url1'].'assets/vendor/modernizr/modernizr.js' ?>"></script>

    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'assets/css/toastr.min.css' ?>">

  </head>
  <body>
    <section class="body">

      <!-- start: header -->
      <!-- start: header -->
      <header class="header">
        <div class="logo-container">
          <a href="../" class="logo">
            <img src="<?= $_SESSION['base_url1'].'assets/images/m.png' ?>" height="35" alt="Porto Admin" />
          </a>
          <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
          </div>
        </div>
      
        <!-- start: search & user box -->
        <div class="header-right">
      
          <span class="separator"></span>
      
          <div id="userbox" class="userbox">
            <a href="#" data-toggle="dropdown">
              <figure class="profile-picture">
                <img src="<?= $_SESSION['base_url1'].'assets/images/!logged-user.jpg" alt="Joseph Doe' ?>" class="img-circle" data-lock-picture="assets/images/!logged-user.jpg" />
              </figure>
              <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                <span class="name">Usuario: <?php echo $_SESSION['user'] ?></span>
                <span class="role">Administrador</span>
              </div>
      
              <i class="fa custom-caret"></i>
            </a>
      
            <div class="dropdown-menu">
              <ul class="list-unstyled">
                <li class="divider"></li>
                <li>
                  <a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="fa fa-user"></i> Mi Perfin</a>
                </li>
                <li>
                  <a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Bloquear Pantalla</a>
                </li>
                <li>
                  <?
                    $ruta_logout = substr($_SESSION['base_url1'], 0, strlen($_SESSION['base_url1']) -1);
                  ?>

                  <a href="<?= $ruta_logout.'?logout=1' ?>" role="menuitem" tabindex="-1" href="pages-signin.html">
                    <i class="fa fa-power-off"></i> Salir</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- end: search & user box -->
      </header>
      <!-- end: header -->
      <?
        include_once 'menu_lateral.php';
      ?>
      
      <section role="main" class="content-body">
        <header class="page-header">
          <h2>Dashboard</h2>
        
          <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
              <li>
                <a href="index.php">
                  <i class="fa fa-home"></i>
                </a>
              </li>
              <li><span>Dashboard</span></li>
            </ol>
        
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
          </div>
        </header>

        <!-- start: page -->
        <div class="row">
          <div class="col-md-12 col-sm-12 col-lg-12 col-xl-6">
