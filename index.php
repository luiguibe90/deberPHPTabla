<?php
$conn = new mysqli("127.0.0.1", "root", "admin123", "registros");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["nombre"])) {
    $stmt = $conn->prepare("INSERT INTO producto (nombre, cantidad, precioUnitario, fechaIngreso) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sids", $nombre, $cantidad, $precioUnitario, $fechaIngreso);
    $nombre = $_POST["nombre"];
    $cantidad = $_POST["cantidad"];
    $precioUnitario = $_POST["precioUnitario"];
    $fechaIngreso = $_POST["fechaIngreso"];
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="sp">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>PHP Tablas</title>

    <link rel="icon" href="./images/logodep.png" type="image/x-icon">

    <link href=".css/simplebar.css" rel="stylesheet" />
    <link href="./css/bootstrap.min.css" rel="stylesheet" />

    <link href="./css/icons.css" rel="stylesheet" type="text/css" />

    <link href="./css/sidebar-menu.css" rel="stylesheet" />

    <link href="./css/app-style.css" rel="stylesheet" />

</head>

<body class="bg-theme1">


    <div id="pageloader-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="loader"></div>
            </div>
        </div>
    </div>



    <div id="wrapper">


        <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
            <div class="brand-logo">
                <a href="index.html">
                    <img src="./images/Logo_ESPE.png" class="logo-icon" alt="logo icon">
                    <h5 class="logo-text">Php Tablas</h5>
                </a>
            </div>
            <ul class="sidebar-menu do-nicescrol">
                <li class="sidebar-header">Menu</li>
                <li>
                    <a href="./index.php">
                        <i class="zmdi zmdi-grid"></i> <span>Stock</span>
                    </a>
                </li>
            </ul>

        </div>

        <header class="topbar-nav">
            <nav class="navbar navbar-expand fixed-top">

            </nav>
        </header>


        <div class="clearfix"></div>



        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Productos Registrados</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="text-align: center;">Código</th>
                                                <th scope="col" style="text-align: center;">Nombre Producto </th>
                                                <th scope="col" style="text-align: center;">Cantidad Stock</th>
                                                <th scope="col" style="text-align: center;">Precio Unitario</th>
                                                <th scope="col" style="text-align: center;">Fecha Ingreso</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = $conn->query("SELECT * from PRODUCTO");
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <th scope="col" style="text-align: center;"><?php echo $row["codProducto"]; ?></th>
                                                        <th scope="col" style="text-align: center;"><?php echo $row["nombre"]; ?></th>
                                                        <th scope="col" style="text-align: center;"><?php echo $row["cantidad"]; ?></th>
                                                        <th scope="col" style="text-align: center;"><?php echo $row["precioUnitario"]; ?></th>
                                                        <th scope="col" style="text-align: center;"><?php echo $row["fechaIngreso"]; ?> </th>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <th scope="col">No hay Datos Registrados</th>
                                                </tr>
                                            <?php  } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">

                                <form name="forma" method="POST" action="index.php">
                                    <h5 class="card-title">Ingreso Nuevo Producto</h5>
                                    <div class="table-responsive">

                                        <table class="table table-hover">

                                            <tr>
                                                <td><label id="lblnombre" for="nombre">Nombre:</label></td>
                                                <td><input type="text" name="nombre" value="" /></td>
                                            </tr>
                                            <tr>
                                                <td><label id="lblcantidad" for="cantidad">Cantidad:</label></td>
                                                <td><input type="text" name="cantidad" value="" /></td>
                                            </tr>
                                            <tr>
                                                <td><label id="lblprecioUnitario" for="precioUnitario">Precio Unitario:</label></td>
                                                <td><input type="text" name="precioUnitario" value="" /></td>
                                            </tr>
                                            <tr>
                                                <td><label id="lblfechaIngreso" for="fechaIngreso">Fecha Ingreso:</label></td>
                                                <td><input type="text" name="fechaIngreso" value="" /></td>
                                            </tr>
                                            <tr>
                                                <td><input type="submit" name="agregar" value="Agregar" /></td>
                                            </tr>

                                        </table>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer class="footer">
        <div class="container">
            <div class="text-center">
                ESPE
            </div>
        </div>
    </footer>
</body>

</html>