<?php

require('../utilities/database.php');

if(!empty($_GET['id'])){
    echo('<H1>'.$_GET['íd'].'</H1>');
    echo('TRUE');

    echo(query("SELECT * FROM Actors"));
    echo('TRUE');
} else {
    echo("No id");
}
?>
