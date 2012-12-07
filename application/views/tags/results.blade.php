<?php
foreach($tag_results as $result)
{
//dd($result->original['name']);
	echo '<li>' . $result->value . '</li>';
}
?>