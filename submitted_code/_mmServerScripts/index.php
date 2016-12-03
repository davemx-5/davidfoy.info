<html> 
<head> <title>index.php</title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
</head> 
<body>
<div id="Form" align="center">
<form method="POST" action=""> 
  <p>
	  <label for="query">Query</label>
	  <br/> 
	  <input name="query" type="text" size="60" maxlength="60" value="" required />	
  </p>
	<p>
	  <label for="Format">Format</label>
	  <select name="Format" id="Format">
        <option value="aggregation">Aggregated</option>
                 <option value="non-aggregation">Non-Aggregated</option>
      </select>
        <label for="MaxResults">MaxResults:</label>
	  <select name="MaxResults" id="MaxResults">
      	   <option value="10">10</option>
           <option value="50">50</option>
           <option value="100">100</option>
      </select>
	</p>
	<p>
	  <input name="bt_search" type="submit" value="Search" /> 
  </p>
	<p><a href="database.php">Please write a review...</a></p>
</form> 
</div>
<div id="results">
<?php


function main() 
{
 	require("search.php");
	
	error_reporting(E_ERROR);
    // take in the parameters
	
//	file_put_contents('log.txt', "New Session\n\n\n");
	
	$query = urlencode("'{$_POST['query']}'");  
	$MaxResults = intval($_POST['MaxResults']);
	$method = $_POST['Format'];
	$normalisedArray = array();
	$normalisedArray = agragate( $query, $MaxResults, $method );
	echoStartHtmlTable();									   
	echoResultsAsTableRows( $normalisedArray , $MaxResults);
	echoEndHtmlTable();
}

main();

?>
</div>		
<h2></h2>
</body> 
</html> 
