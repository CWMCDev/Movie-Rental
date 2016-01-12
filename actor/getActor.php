<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/classes/databasecomm.class.php");

$title = "Actors";

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/header.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/actorTemplate.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/movieTemplate.php");

if(!empty($_GET['id'])){
	$id = $_GET['id'];
	$firstName = '';
	$lastName = '';

    $actorObj = getActor($_GET['id']);

    echo '<div class="col-md-12">';

	if ($actorObj == false){
		return $actorObj;
	}

    while($actor = mysqli_fetch_array($actorObj)){
    	showInfoForActor($actor, 6, 4);
    }

    echo'
        <div class="col-md-6 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Movies:</h3>
                </div>
                <div class="panel-body">';
                    $movieObjs = getMoviesFromActor($id);

                    if ($movieObjs == false){
                        return $movieObjs;
                    }

                    while($movie = mysqli_fetch_array($movieObjs)){
                        showInfoForMovie($movie);
                        echo '<div class="col-md-1"></div>';
                    }
    echo '      </div>
            </div>
        </div>
    </div>
    ';


} else {
    echo'
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Featured Actors</h3>
            </div>
            <div class="panel-body">';
                $actorObj = getRandomActors(4);

                if ($actorObj == false){
                    return $actorObj;
                }

                while($actor = mysqli_fetch_array($actorObj)){
                    showInfoForActor($actor);
                    echo '<div class="col-md-1"></div>';
                }
    echo '  </div>
        </div>
    </div>
    ';

}

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/footer.php");
?>
