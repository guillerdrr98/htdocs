<?php

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

echo "<ul>";

foreach($gente as $familia){
    echo "<li>" . $familia['Familia'] . "</li>";

    echo "<ul>";
    
    echo "<li>Padre: " . $familia['Padre'] . "</li>";
    echo "<li>Madre: " . $familia['Madre'] . "</li>";
    
    echo "<li>Hijos:</li>";
    echo "<ul>";

    foreach($familia['Hijos'] as $hijo){
        echo "<li>" . $hijo . "</li>";
    }

    echo "</ul>";
    echo "</ul>";
}

echo "</ul>";

?>