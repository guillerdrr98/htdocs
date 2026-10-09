<?php
/*//CREAR UN ARRAY LLAMADO "ANIMAL" QUE TENGA UNA ESTRUCTURA MULTIDIMENSIONAL
//CON INDICES

$animal = array(
    array("Perro", "Gato"),
    array("Lombriz", "Burro"),
    array("Murciélago", "Cocodrilo")
);

print_r($animal);//Imprime toda la estructura del array

echo "<br>";

var_dump($animal);//Imprime toda la estructura del array con mayor detalle

echo "<br>";

foreach($animal as $grupo){
    foreach($grupo as $nombre){
        echo $nombre . "<br>";
    }
}
*/
/*for($i = 0; $i < count($animal); $i++){
    for($j = 0; $j < count($animal[$i]); $j++){
        echo $animal[$i][$j] . "<br>";
    }
}*/
/*
$animalM = array(
    "casa" => array("Perro", "Gato"),
    "granja" => array("Lombriz", "Burro"),
    "salvaje" => array("Murciélago", "Cocodrilo")
);

var_dump($animalM);

echo "<br>";

print_r($animalM);

echo "<br>";

/*for($i = 0; $i < count($animalM); $i++){
    for($j = 0; $j < count($animalM[$i]); $j++){ //AL NO TENER ÍNDICES NUMÉRICOS NO PODEMOS RECORRER EL ARRAY CON UN FOR
        echo $animalM[$i][$j] . "<br>";
    }
}*/
/*
foreach($animalM as $grupo){
    foreach($grupo as $nombre){
        echo $nombre . "<br>";
    }
}
*/

$gente = array(
    array(
        'Familia' => 'Los Simpson',
        'Padre' => 'Homer',
        'Madre' => 'Marge',
        'Hijos' => array('Bart', 'Lisa', 'Maggie')
    ),
    array(
        'Familia' => 'Los Griffin',
        'Padre' => 'Peter',
        'Madre' => 'Lois',
        'Hijos' => array('Chris', 'Meg', 'Stewie')
    )
);

var_dump($gente);

echo "<br>";

print_r($gente);

echo "<br>";

foreach($gente as $familia){
    foreach($familia as $info){
        if(is_array($info)){
            echo "<br>";
            foreach($info as $hijo){
                echo $hijo . "<br>";
            }
            echo"<br>";
        }else{
            echo $info." ";
        }
    }
}
?>