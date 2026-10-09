<?php
    $valor = " Es tu nombre O\'reilly? ";
    $resultado = trim($valor); //$trim elimina los espacios de la cadena
    echo $resultado;

    $resultado = stripslashes($valor); //$stripslashes elimina las barras \
    //echo $resultado;

    //Funcion que elimina las barras \ y los espacios de la cadena pasada por parámetro
    function test_entrada($valor) {
        $valor = trim($valor);
        $valor = stripslashes($valor);
        return $valor;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <input type="radio" name="sexo"
    <?php if (isset($sexo) && $sexo=="mujer") echo "checked";?>
    value="mujer"> Mujer
    <input type="radio" name="sexo"
    <?php if (isset($sexo) && $sexo=="hombre") echo "checked";?>
    value="hombre"> Hombre
    <span class="error">* <?php echo $sexoErr;?></span><br><br>
</body>
</html>