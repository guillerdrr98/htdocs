<?php
// ==========================================================
// EJERCICIO 3 - VER RESULTADOS (resultado.php)
// ==========================================================
session_start();
require_once('conexion.php');

// Si no hay usuario logueado o no viene del formulario, volvemos atrás
if (!isset($_SESSION['login'])) {
    header("Location: entrada.php");
    exit();
}
if (!isset($_POST['pos1'])) {
    header("Location: mostrarcartas.php");
    exit();
}

// Datos de la jugada
$pos1     = $_POST['pos1'];
$pos2     = $_POST['pos2'];
$intentos = $_SESSION['levantadas'];
$cartas   = $_SESSION['cartas'];

// ----------------------------------------------------------
// Comprobamos si las dos posiciones forman pareja:
// deben ser posiciones distintas y tener la misma carta
// (restamos 1 porque el array empieza en 0)
// ----------------------------------------------------------
if ($pos1 != $pos2 && $cartas[$pos1 - 1] == $cartas[$pos2 - 1]) {
    // c) Mensaje de acierto: se suma 1 punto
    $mensaje = "Acierto posiciones $pos1 y $pos2 después de $intentos intentos";
    $detalle = "Se le sumará 1 punto, así como $intentos intentos";
    $puntos  = 1;
} else {
    // b) Mensaje de fallo: se resta 1 punto
    $mensaje = "Fallo posiciones $pos1 y $pos2 después de $intentos intentos";
    $detalle = "Se le restará 1 punto, así como $intentos intentos";
    $puntos  = -1;
}

// ----------------------------------------------------------
// d) Actualizamos la BD: puntos (+1 o -1) y el número
//    de intentos se acumula en el campo extra
// ----------------------------------------------------------
$stmt = $conn->prepare("UPDATE jugador SET puntos = puntos + ?, extra = extra + ? WHERE login = ?");
$stmt->bind_param("iis", $puntos, $intentos, $_SESSION['login']);
$stmt->execute();

// ----------------------------------------------------------
// e) Leemos la tabla de puntos ya actualizada
// ----------------------------------------------------------
$resultado = $conn->query("SELECT nombre, puntos, extra FROM jugador ORDER BY nombre");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
</head>
<body>
    <!-- a) Mensaje de bienvenida -->
    <h1>Bienvenid@, <?php echo $_SESSION['nombre']; ?></h1>
    <br><br>

    <!-- b) y c) Mensaje de fallo o de acierto -->
    <h1><?php echo $mensaje; ?></h1>
    <h4><?php echo $detalle; ?></h4>

    <!-- e) Tabla de puntos por jugador -->
    <h2>Puntos por jugador</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Puntos</th>
            <th>Extra</th>
        </tr>
        <?php
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $fila['nombre'] . "</td>";
            echo "<td>" . $fila['puntos'] . "</td>";
            echo "<td>" . $fila['extra'] . "</td>";
            echo "</tr>";
        }
        $conn->close();
        ?>
    </table>
    <br>
    <a href="mostrarcartas.php">Jugar otra vez</a>
</body>
</html>
