<?php
function showInfoForActor($actor){
	$id = $actor['actor_id'];
	$firstName = $actor['firstname'];
	$lastName = $actor['lastname'];
	echo'
	<div class="col-md-3 lib-item" data-category="view">
		<a href="/actor/getActor.php?id='.$id.'">
		    <div class="lib-panel">
		        <div class="row box-shadow">
		            <div class="col-md-6">
		                <img class="lib-img-show" src="/actor/img/'.$id.'.jpg">
		            </div>
		            <div class="col-md-6">
		                <div class="lib-row lib-header">
		                    '.$firstName.' '.$lastName.'
		                    <div class="lib-header-seperator"></div>
		                </div>
		                <div class="lib-row lib-desc">
		                    Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor
		                </div>
		            </div>
		        </div>
		    </div>
		</a>
	</div>';
}
?>