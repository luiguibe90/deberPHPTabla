<?php
$conn = new mysqli("127.0.0.1", "root", "admin123", "registros");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$nombre = "";
$cantidad = "";
$precioUnitario = "";
$fechaIngreso = "";
$accion = "Agregar";
$codProducto = "";

if (isset($_POST["accion"]) && ($_POST["accion"] == "Agregar")) {
    $stmt = $conn->prepare("INSERT INTO producto (nombre, cantidad, precioUnitario, fechaIngreso) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sids", $nombre, $cantidad, $precioUnitario, $fechaIngreso);
    $nombre = $_POST["nombre"];
    $cantidad = $_POST["cantidad"];
    $precioUnitario = $_POST["precioUnitario"];
    $fechaIngreso = $_POST["fechaIngreso"];
    $stmt->execute();
    $stmt->close();
    $nombre = "";
    $cantidad = "";
    $precioUnitario = "";
    $fechaIngreso = "";
} else if (isset($_POST["accion"]) && ($_POST["accion"] == "Modificar")) {
    $stmt = $conn->prepare("UPDATE producto set nombre= ?, cantidad=?, precioUnitario=?, fechaIngreso=? where codProducto=?");
    $stmt->bind_param("sidsi", $nombre, $cantidad, $precioUnitario, $fechaIngreso, $codProducto);
    $nombre = $_POST["nombre"];
    $cantidad = $_POST["cantidad"];
    $precioUnitario = $_POST["precioUnitario"];
    $fechaIngreso = $_POST["fechaIngreso"];
    $codProducto = $_POST["codProducto"];
    $stmt->execute();
    $stmt->close();
    $nombre = "";
    $cantidad = "";
    $precioUnitario = "";
    $fechaIngreso = "";
} else if (isset($_GET["update"])) {
    $result = $conn->query("SELECT * FROM PRODUCTO WHERE codProducto=" . $_GET["update"]);
    if ($result->num_rows > 0) {
        $row1 = $result->fetch_assoc();
        $codProducto = $row1["codProducto"];
        $nombre = $row1["nombre"];
        $cantidad = $row1["cantidad"];
        $precioUnitario = $row1["precioUnitario"];
        $fechaIngreso = $row1["fechaIngreso"];
        $accion = "Modificar";
    }
} else if (isset($_POST["elimCodigoP"])) {
    $stmt = $conn->prepare("DELETE FROM producto WHERE codProducto=?");
    $stmt->bind_param("i", $codProducto);
    $codProducto = $_POST["elimCodigoP"];
    $stmt->execute();
    $stmt->close();
    $codProducto = "";
}
?>

<!DOCTYPE html>
<html lang="sp">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Master PC</title>

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
            <div class="brand-logo ">
                <a href="index.html">
                    <img src="./images/Logo_ESPE.png" class="logo-icon" alt="logo icon">
                    <h5 class="logo-text">Master PC</h5>
                </a>
            </div>
            <ul class="sidebar-menu do-nicescrol ">
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
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form id="forma" name="forma" method="post" action="index.php">
                                    
                                    <h5 class="card-title">Productos Registrados</h5>
                                    <div class="table-responsive">
                                        <table>
                                            <tr>
                                                <td scope="col" style="width: 1010px;">&nbsp;</td>
                                                <th><input type="button" name="eliminar"class=" btn btn-light btn-round px-4 " value="Eliminar" onclick="eliminarProducto();"></th>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="text-align: center;">Código</th>
                                                    <th scope="col" style="text-align: center;">Nombre Producto </th>
                                                    <th scope="col" style="text-align: center;">Cantidad Stock</th>
                                                    <th scope="col" style="text-align: center;">Precio Unitario</th>
                                                    <th scope="col" style="text-align: center;">Fecha Ingreso</th>
                                                    <th scope="col" style="text-align: center;">ELIM.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $result = $conn->query("SELECT * from producto");
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                ?>
                                                        <tr>
                                                            <th scope="col" style="text-align: center;"><a href="index.php?update=<?php echo $row["codProducto"]; ?>"><?php echo $row["codProducto"]; ?></a></th>
                                                            <th scope="col" style="text-align: center;"><?php echo $row["nombre"]; ?></th>
                                                            <th scope="col" style="text-align: center;"><?php echo $row["cantidad"]; ?></th>
                                                            <th scope="col" style="text-align: center;"><?php echo $row["precioUnitario"]; ?></th>
                                                            <th scope="col" style="text-align: center;"><?php echo $row["fechaIngreso"]; ?> </th>
                                                            <th scope="col" style="text-align: center;"><input type="radio" name="elimCodigoP" value="<?php echo $row["codProducto"]; ?>"></th>
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
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" name="codProducto" value="<?php echo $codProducto; ?>" />
                                <h5 class="card-title">Gestión Producto</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tr>
                                            <td><label id="lblnombre" for="nombre">Nombre:</label></td>
                                            <td><input type="text" name="nombre" value="<?php echo $nombre; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td><label id="lblcantidad" for="cantidad">Cantidad:</label></td>
                                            <td><input type="text" name="cantidad" value="<?php echo $cantidad; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td><label id="lblprecioUnitario" for="precioUnitario">Precio Unitario:</label></td>
                                            <td><input type="text" name="precioUnitario" value="<?php echo $precioUnitario; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td><label id="lblfechaIngreso" for="fechaIngreso">Fecha Ingreso:</label></td>
                                            <td><input type="text" name="fechaIngreso" value="<?php echo $fechaIngreso; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td><input type="submit" class=" btn btn-light btn-round px-5 " name="accion" value="<?php echo $accion; ?>" /></td>
                                        </tr>

                                    </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--   <footer class="footer">
        <div class="container">
            <div class="text-center">
                ESPE
            </div>
        </div>
    </footer> -->
</body>
<script>
    function eliminarProducto() {
        document.getElementById('forma').submit();
    }
</script>

</html>