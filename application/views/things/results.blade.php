<?php
foreach($tags_result as $result)
{
//dd($result->original['name']);
	echo '<li>' . $result->name . '</li>';
}
?>