<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style = 'background-color: <?=$_SESSION['fondo_cookie']?>'>
    <h3 style='color: green;'>¡Enhorabuena! Has ganado</h3>
    <p><strong>La combinación correcta era: </strong><?=implode(", ", $_SESSION['combinacion_colores_texto'])?></p>
    <?=$_SESSION['solucion']?><br>
    <a href="../ManejoPartida/config.php"><button>Jugar otra vez</button></a>
    <a href="../ManejoPartida/index.php"><button>Salir</button></a>
</body>
</html>