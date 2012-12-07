<?php
foreach($suggestive_results as $result)
{
//dd($result->original['name']);
	echo '<li>' . $result->name . '</li>';
}
?>