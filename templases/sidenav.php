<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Inventario
                </a>
                <?php
                if ($_SESSION['puesto'] == "admin") {
                ?>
                    <div class="sb-sidenav-menu-heading">Administración</div>
                    <a class="nav-link" href="ubicacion.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-map-location-dot"></i></div>
                        Ubicaciones
                    </a>
                    <a class="nav-link" href="empleado.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-person"></i></div>
                        Empleados
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Ha ingresado:</div>
            <?php echo $_SESSION['nombre'] ?>
        </div>
    </nav>
</div>