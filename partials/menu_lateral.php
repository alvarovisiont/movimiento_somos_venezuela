<div class="inner-wrapper">
        <!-- start: sidebar -->
        <aside id="sidebar-left" class="sidebar-left">
        
            <div class="sidebar-header">
                <div class="sidebar-title">
                    Navigation
                </div>
                <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                    <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                </div>
            </div>
            <div class="nano">
                <div class="nano-content">
                    <nav id="menu" class="nav-main" role="navigation">
                        <ul class="nav nav-main">
                            <li class="nav-active">
                            <a href="index.php">
                              <i class="fa fa-home" aria-hidden="true"></i>
                              <span>Dashboard</span>
                            </a>
                            </li>
                            <li class="nav-parent">
                                <a>
                                  <i class="fa fa-users" aria-hidden="true"></i>
                                  <span>Cuentas</span>
                                </a>
                                <ul class="nav nav-children">
                                  <?
                                    if($_SESSION['nivel'] == 1)
                                    {
                                  ?>
                                      <li>

                                          <a href="<?= $_SESSION['base_url1'].'app/estado/municipio.php' ?>">
                                             Municipios
                                          </a>
                                      </li>
                                    <?
                                    }
                                    ?>
                                  <?
                                    if($_SESSION['nivel'] < 3)
                                    {
                                  ?>
                                      <li>
                                        <a href="<?= $_SESSION['base_url1'].'app/estado/parroquias.php' ?>">
                                           Comités
                                        </a>
                                      </li>
                                  <?
                                    }
                                  ?>

                                </ul>
                            </li>
                            <li class="nav-parent">
                                <a>
                                  <i class="fa fa-users" aria-hidden="true"></i>
                                  <span>Cuentas Centros</span>
                                </a>
                                <ul class="nav nav-children">
                                  <li>
                                    <a href="<?= $_SESSION['base_url1'].'app/usuario/index.php' ?>">
                                       Ver Centros
                                    </a>
                                  </li>
                                  <li>
                                    <a href="<?= $_SESSION['base_url1'].'app/usuario/form.php' ?>">
                                       Crear Centro
                                    </a>
                                  </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </aside>