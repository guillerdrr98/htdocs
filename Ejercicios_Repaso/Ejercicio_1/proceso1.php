<?php
    session_start();

    if(!isset($_SESSION['numero'])){
        $_SESSION['numero'] = 0;
    }

    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];

        if($accion ==='subir'){
            $_SESSION['numero']++;
        }elseif($accion === 'bajar'){
            $_SESSION['numero']--;
        }elseif($accion === 'cero'){
            $_SESSION['numero'] = 0;
        }
    }

    header('Location: ejercicio1.php');
    exit();
?>