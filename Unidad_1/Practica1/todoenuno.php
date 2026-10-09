<?php

// Si se ha enviado el formulario
//if ($_SERVER["REQUEST_METHOD"] === "POST"){
if (isset($_POST["num1"])) { // isset() comprueba que una variable exista (not null)

    $num1 = $_POST["num1"];
    $num2 = $_POST["num2"];
    $operacion = $_POST["operacion"];

    $resultado = match ($operacion) {
        "+" => $num1 + $num2,
        "-" => $num1 - $num2,
        "*" => $num1 * $num2,
        "/" => $num2 == 0
            ? "No se puede dividir entre cero."
            : $num1 / $num2,
        default => "Operación no válida",
    };

    // Página de resultado
    ?>

    <!doctype html>
    <html lang="es">
      <head>
        <meta charset="UTF-8">
        <title>Resultado</title>
      </head>

      <body>

        <p>
          El resultado de
          <?= $num1 ?>
          <?= $operacion ?>
          <?= $num2 ?>
          es
          <?= $resultado ?>
        </p>

        <a href="todoenuno.php">Volver a la calculadora</a>

      </body>
    </html>

    <?php

// Si NO se ha enviado el formulario
} else {

    // Página del formulario
    ?>

    <!doctype html>
    <html lang="es">
      <head>
        <meta charset="UTF-8">
        <title>Calculadora</title>
      </head>

      <body>

        <form
          action="todoenuno.php"
          method="POST"
          style="border: 1px solid black; padding: 20px; width: 250px"
        >
          <label for="num1">Número 1</label><br>
          <input type="number" id="num1" name="num1" required>
          <br><br>

          <label for="num2">Número 2</label><br>
          <input type="number" id="num2" name="num2" required>
          <br><br>

          <label for="operacion">Operación</label><br>

          <select id="operacion" name="operacion" required>
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
          </select>

          <br><br>

          <button type="submit">Calcula</button>
        </form>

      </body>
    </html>

    <?php
}
?>