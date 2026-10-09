<?php
$usu = 'pepe';
$pass = '123456';

//echo "Ejecutando primera validación <br>";
$n = $_POST['usuario']; //Si en el name del formulario pone 'nombre', no puedo identificar el valor del usuario como 'usuario', sino como 'nombre'
$p = $_POST['password'];

if($n === $usu && $p === $pass){
    echo "Enhorabuena, te has loggeado correctamente";
}else{
    echo "El usuario o la contraseña son incorrectos";
}

//for($i=0; $i<10; $i++){
//    echo "Yolanda nos está castigando a escribir 10 veces el nombre $n y la password $p <br>";
//}


// DEBERES: HACER UN FORMULARIO CON 2 CELDAS PARA NÚMEROS, UN DESPLEGABLE PARA OPERACIÓNES (+,-,*,/) Y UN BOTÓN "CALCULA"
// EL RESULTADO DE LA OPERACIÓN DEBE MOSTRARSE COMO UNA CADENA QUE DIGA "EL RESULTADO DE $NUM1 $OPERACION $NUM2 ES $RESULTADO"
?>