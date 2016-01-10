<?php

require('../utilities/database.php');

if(!empty($_GET['id'])){
    echo('<H1>'.$_GET['íd'].'</H1>');
    echo('TRUE');

    echo(query("SELECT * FROM Actors"));
} else {
    echo("No id");
}
?>
