<?php
    session_start();
    require_once('../ConexionBD/funcionesBusqueda.php');
    registrarJugada($_SESSION['nom_usuario'], 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style = 'background-color: <?=$_SESSION['fondo']?>'>
    <h3 style='color: green;'>¡Enhorabuena! Has ganado (Se ha guardado en la base de datos acierto = 1)</h3>
    <p><strong>La combinación correcta era: </strong><?=implode(", ", $_SESSION['combinacion_colores_texto'])?></p>
    <?=$_SESSION['solucion']?><br>
    <a href="../ManejoPartida/solucion.php"><button>Jugar otra vez</button></a>
    <a href="ranking.php"><button>Estadística</button></a>
</body>
</html>