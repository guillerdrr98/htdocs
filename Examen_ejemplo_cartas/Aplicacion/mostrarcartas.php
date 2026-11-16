<?php
    session_start();
    require_once 'funciones.php';

    if (!isset($_SESSION['mazo'])) {
        $cartasBase = ['copas_02.jpg', 'copas_03.jpg', 'copas_05.jpg'];
        $_SESSION['mazo'] = generarMazo($cartasBase);
        $_SESSION['intentos'] = 0;
    }

    $cartaLevantada = -1;


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['levantar'])) {
        $cartaLevantada = (int)$_POST['levantar'];
        $_SESSION['intentos']++;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartas - Partida</title>
</head>
<body>
    <h1>¡Bienvenid@, <?=$_SESSION['nom_usuario']?>!</h1>

    <br><br>

    <p>
        <strong>Cartas levantadas:</strong>
        <input type="text" value="<?php echo $_SESSION['intentos']; ?>" readonly>
    </p>

    <br><br>

    <form method="post" action="mostrarcartas.php">
        <?php
            for ($i = 0; $i < 6; $i++) {
                echo '<button type="submit" name="levantar" value="' . $i . '">Levantar carta ' . ($i + 1) . '</button> ';
            }
        ?>
    </form>

    <br><br>

    <form method="post" action="resultado.php">
        <strong>Pareja:</strong>
        <input type="number" name="pos1" min="1" max="6" required>
        <input type="number" name="pos2" min="1" max="6" required>
        <button type="submit" name="comprobar">Comprobar</button>
    </form>

    <br>

    <div>
        <?php
            pintarCartas($_SESSION['mazo'], $cartaLevantada);
        ?>
    </div>

</body>
</html>