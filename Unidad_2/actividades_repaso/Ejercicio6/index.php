<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simón dice... - Configuración</title>
</head>
<body>
    <h2>Formulario de Configuración</h2>
    <form action="solucion.php" method="POST">
        <label for="nom_usuario">Nombre:</label>
        <input type="text" id="nom_usuario" name="nom_usuario" required><br><br>

        <label for="num_circulos">Número de círculos (entre 4 y 8):</label>
        <input type="number" id="num_circulos" name="num_circulos" value="4" min="4" max="8" required><br><br>

        <label for="num_colores">Número de colores a usar (máximo 8):</label>
        <input type="number" id="num_colores" name="num_colores" value="1" min="1" max="8" required><br><br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>