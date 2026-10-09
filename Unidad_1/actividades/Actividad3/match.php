<?php
    $calificacion = 8;

    $res = match($calificacion){
        0 => "suspenso",
        1 => "suspenso",
        2 => "suspenso",
        3 => "suspenso",
        4 => "suspenso",
        5 => "aprobado",
        6 => "bien",
        7 => "notable",
        8 => "notable",
        9 => "sobresaliente",
        10 => "sobresaliente",
    };

    echo $res;

?>