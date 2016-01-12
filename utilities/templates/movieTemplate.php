<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/utilities/classes/databasecomm.class.php");

function showInfoForMovie($movie, $mdWidth = 12, $lgWidth = 6){
	$id = $movie['film_id'];
	$title = $movie['name'];
	$releaseDate = $movie['release_date'];
	$description = $movie['description'];
	$length = $movie['length'];
	$rating = $movie['rating'];
	echo'
	<div class="col-md-'.$mdWidth.' col-lg-'.$lgWidth.' lib-item" data-category="view">
	    <div class="lib-panel">
	        <div class="row box-shadow">
	            <div class="col-md-6">
	                <img class="lib-img-show" src="/movie/img/'.$id.'.jpg">
	            </div>
	            <div class="col-md-6">
	                <a href="/movie/getMovie.php?id='.$id.'" >
		                <div class="lib-row lib-header">
		                    '.$title.'
		                    <div class="lib-header-seperator"></div>
		                </div>
		            </a>
	                <div class="lib-row lib-desc">
	                    '.$description.'
	                    <br /> <br />
	                    Length: '.$length.' min
	                    <br /> <br />
	                    Rating: '.$rating.' stars
	                    <br /> <br />
	                    ';
	                    $categoryObjs = getCategoriesFromMovie($id);
	                    $categoryList = '';
	                    while($category = mysqli_fetch_array($categoryObjs)){
                        	if ($categoryList == ''){
                        		$categoryList = $category['category'];
                        	} else {
                        		$categoryList .= ' - '.$category['category'];
                        	}
                    	}
                    	echo 'Categories: '.$categoryList;

				echo'</div>
	            </div>
	        </div>
	    </div>
	</div>';
}
?>