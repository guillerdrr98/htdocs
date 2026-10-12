<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración de Círculos</title>
</head>
<body>
    <h2>Formulario de Configuración</h2>
    <form action="resultado.php" method="POST">
        <label for="num_circulos">Número total de círculos:</label>
        <input type="number" id="num_circulos" name="num_circulos" min="4" max="8" value="4" required><br><br>

        <label for="num_colores">Número de colores de la paleta:</label>
        <input type="number" id="num_colores" name="num_colores" min="1" max="8" value="4" required><br><br>

        <button type="submit">Generar Círculos</button>
    </form>
</body>
</html>