<?php

$nombre = "";
$email = "";
$web = "";
$comentario = "";
$sexo = "";

$nombreErr = "";
$emailErr = "";
$webErr = "";
$sexoErr = "";


/* Función para validar el nombre */
function validar_nombre($nombre)
{
    if (empty($nombre)) {
        return "El nombre es obligatorio";
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $nombre)) {
        return "Únicamente se permiten letras y espacios";
    }

    return "";
}


/* Función para validar el email */
function validar_email($email)
{
    if (empty($email)) {
        return "El email es obligatorio";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Formato de email inválido";
    }

    return "";
}


/* Función para validar la URL */
function validar_url($web)
{
    if (!filter_var($web, FILTER_VALIDATE_URL)) {
        return " URL inválida";
    }

    return "";
}


/* Función para validar el sexo */
function validar_sexo($sexo)
{
    if (empty($sexo)) {
        return "El sexo es obligatorio";
    }

    return "";
}


/* Comprobamos si se ha enviado el formulario */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* Recogemos y limpiamos los datos */

    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $web = $_POST["web"];
    $comentario = $_POST["comentario"];

    if (isset($_POST["sexo"])) {
        $sexo = $_POST["sexo"];
    }


    /* Llamamos a las funciones de validación */

    $nombreErr = validar_nombre($nombre);
    $emailErr = validar_email($email);
    $webErr = validar_url($web);
    $sexoErr = validar_sexo($sexo);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Ejemplo de Validación de Formularios PHP</title>

    <style>

        .error {
            color: red;
        }

    </style>

</head>

<body>

    <h2>Ejemplo de Validación de Formularios PHP</h2>

    <span class="error">* Campos requeridos</span>

    <br><br>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

        <!-- NOMBRE -->

        Nombre:

        <input
            type="text"
            name="nombre"
            value="<?php echo $nombre; ?>"
        >

        <span class="error">
            * <?php echo $nombreErr; ?>
        </span>

        <br><br>


        <!-- EMAIL -->

        E-mail:

        <input
            type="text"
            name="email"
            value="<?php echo $email; ?>"
        >

        <span class="error">
            * <?php echo $emailErr; ?>
        </span>

        <br><br>


        <!-- WEBSITE -->

        Página Web:

        <input
            type="text"
            name="web"
            value="<?php echo $web; ?>"
        >

        <span class="error">
            <?php echo $webErr; ?>
        </span>

        <br><br>


        <!-- COMENTARIO -->

        Comentarios:

        <textarea
            name="comentario"
            rows="5"
            cols="40"
        ><?php echo $comentario; ?></textarea>

        <br><br>


        <!-- SEXO -->

        Gender:

        <input
            type="radio"
            name="sexo"
            value="Mujer"
            <?php if (isset($sexo) && $sexo == "Mujer") echo "checked"; ?>
        >

        Mujer

        <input
            type="radio"
            name="sexo"
            value="Hombre"
            <?php if (isset($sexo) && $sexo == "Hombre") echo "checked"; ?>
        >

        Hombre

        <input
            type="radio"
            name="sexo"
            value="Otro"
            <?php if (isset($sexo) && $sexo == "Otro") echo "checked"; ?>
        >

        Otro

        <span class="error">
            * <?php echo $sexoErr; ?>
        </span>

        <br><br>


        <!-- BOTÓN -->

        <input type="submit" value="Enviar">

    </form>


    <?php

    /**
     * Si colocamos <input type="button" value="Reset" onclick="window.location.href='<?php echo $_SERVER["PHP_SELF"]; ?>';"> en la sección botones del html anterior,
     * implementamos un botón que reinicia el formulario después de haber enviado ciertos datos
     */

    /* Mostramos los datos introducidos */

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        echo "<h2>Datos Introducidos:</h2>";

        echo $nombre . "<br>";
        echo $email . "<br>";
        echo $web . "<br>";
        echo $comentario . "<br>";
        echo $sexo . "<br>";
    }

    ?>

</body>

</html>