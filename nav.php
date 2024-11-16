<!-- nav.php -->
<div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand visible-xs-block visible-sm-block" href="">Inicio</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
        <li><a href="index.php">Inicio</a></li>
            <!-- Enlace para agregar usuario -->
            <?php if ($_SESSION['rol_desc'] == 'Admin') { ?>
                <li><a href="addUsuario.php">Agregar Usuario</a></li>
                <li><a href="prestamo.php">Prestar Libro</a></li> <!-- Enlace a la página de préstamo -->
                <!-- Otras opciones administrativas -->
            <?php } ?>
            <li><a href="logout.php"><i class="fa fa-th-large"></i> Salir</a></li>
        </ul>
    </div><!--/.nav-collapse -->
</div>