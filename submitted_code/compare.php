
<?php


function cmpURL($URL1, $URL2)
{
	$URL1NEW=$URL1;
	$URL2NEW=$URL2;
	
	$URL1NEW=str_replace("http://", "", $URL1);
	$URL1NEW=str_replace("https://", "", $URL1);
	$URL2NEW=str_replace("http://", "", $URL2);
	$URL2NEW=str_replace("https://", "", $URL2);
	
	$result = strcmp( $URL1NEW, $URL2NEW );
	return $result;
}		

?>
