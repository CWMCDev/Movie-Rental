<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/classes/databasecomm.class.php");

$title = "Movies";

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/header.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/actorTemplate.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/movieTemplate.php");

if(!empty($_GET['id'])){
	$id = $_GET['id'];

    $movieObj = getMovie($_GET['id']);

    echo '<div class="col-md-12">';

	if ($movieObj == false){
		return $movieObj;
	}

    while($movie = mysqli_fetch_array($movieObj)){
    	showInfoForMovie($movie, 6, 4);
    }

    echo'
        <div class="col-md-6 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Actors:</h3>
                </div>
                <div class="panel-body">';
                    $actorObjs = getActorsFromMovie($id);

                    if ($actorObjs == false){
                        return $actorObjs;
                    }

                    while($actor = mysqli_fetch_array($actorObjs)){
                        showInfoForActor($actor, 12, 3);
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
                <h3 class="panel-title">Featured Movies</h3>
            </div>
            <div class="panel-body">';
                $movieObj = getRandomMovies(4);

                if ($movieObj == false){
                    return $movieObj;
                }

                while($movie = mysqli_fetch_array($movieObj)){
                    showInfoForMovie($movie, 6, 3);
                    echo '<div class="col-md-1"></div>';
                }
    echo '  </div>
        </div>
    </div>
    ';

}

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/templates/footer.php");
?>
