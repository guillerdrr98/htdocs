<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST["color"])){
        $_SESSION['combinacion'] = array("negro","negro","negro","negro");
        $_SESSION['pulsaciones'] = 0;
    }else{
        $_SESSION['combinacion'][$_SESSION['pulsaciones']] = $_POST["color"];
        $_SESSION['pulsaciones']++;
    };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?= var_dump($_SESSION['combinacion']) ?>
    <form method = "POST">
        <button id = "boton1" name= "color" style="margin: 4px; background-color: red; color: black;" value= "rojo">rojo</button>
        <button id = "boton2" name = "color" style="margin: 4px; background-color: green; color: black;" value = "verde">verde</button>
    </form>
</body>
</html>