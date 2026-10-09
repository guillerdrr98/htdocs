<?php
// Primera página: recibimos la cantidad de números
if (isset($_POST["cantidad"])) {

    $cantidad = $_POST["cantidad"];

    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Introducir números</title>
    </head>
    <body>

        <form action="suma.php" method="post">

            <?php
            for ($i = 1; $i <= $cantidad; $i++) {
                echo "<label for='n$i'>n$i: </label>";
                echo "<input type='number' name='numeros[]' required>";
                echo "<br><br>";
            }
            ?>

            <button type="submit">Sumar</button>

        </form>

    </body>
    </html>

    <?php
}

// Segunda página: recibimos los números y hacemos la suma
elseif (isset($_POST["numeros"])) {

    $resultado = 0;

    foreach ($_POST["numeros"] as $numero) {
        $resultado += $numero;
    }

    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Resultado</title>
    </head>
    <body>

        <h1>El resultado de la suma es <?php echo $resultado; ?></h1>

    </body>
    </html>

    <?php
}
?>