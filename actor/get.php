<?php

include_once("utilities/database/databasecomm.php");

if(!empty($_GET['id'])){
    echo('<H1>'.$_GET['íd'].'</H1>');
    echo('TRUE');

    echo(getAllActors());
    echo('TRUE');
} else {
    echo("No id");
}
?>
