<html> 
<head> <title>runtests.php</title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
</head> 
<body>


<?php

include "test2.php";
include "search.php";

//"aggregation"
function RunTests( $query, $method, $search, $MaxResults) 
{
	
	$filename = "results/TestResult-$method-$query-$search"; // results\TestResult-$method-$query-$search
	
	$fp = fopen($filename, 'w');
	
    // load test data in to a XML dom for searching
	$dom = ReadTestDataIntoXMLDom();
	echo "<p> Testing Started...</p>";
	
	if($search == "BLEKKO")
	{	
		$normalisedArray = getNormalisedblekkoResults(urlencode("'{$query}'"), $MaxResults);
	}
	else if($search == "YAHOO")
	{
		$normalisedArray = getNormalisedYahooResults(urlencode("'{$query}'") , $MaxResults);
	}
	else if($search == "BING")
	{	
		$normalisedArray = getNormalisedBingResults(urlencode("'{$query}'") , $MaxResults);
	}
	else if($method =="aggregation")
	{
		$normalisedArray = search( urlencode("'{$query}'"), $MaxResults, $method );
	}
	$referenceURLS = getReferenceURLSForQuery( $dom , $query ); 		
	$noOfReleventFinds = getReleventFindsForMetaSearchResultsComparedToGoldStandard( $referenceURLS , $normalisedArray );
	$precision = getPrecision($noOfReleventFinds, $MaxResults);
	$recall = getRecall($noOfReleventFinds, $referenceURLS);
	$precisionAtTen = precisionAtTen($referenceURLS, $normalisedArray );
	$f_measure = f_measure($precision, $recall);
	$ave_precision = ave_precision($precision, $recall, $normalisedArray);
	$resultsStats = "Results for query($query), Number of Relevent Finds($noOfReleventFinds), Precision($precision%), Recall($recall%), Precision At Ten($precisionAtTen%), fmeasure = ($f_measure), Average Precision = ($ave_precision).\n";
	fwrite($fp, $resultsStats);
	echo "<p>". $resultsStats. "</p>";

	for ($i = 0; $i < count($normalisedArray); $i++) 
	{
		$no = $i+1;
		$URL = $normalisedArray[$i]->URL;
		$resultURL =  "$no - $URL\n";
		fwrite($fp, $resultURL);
	}
	echo "<p> Testing Completed and results available in \"". $filename . "\"...</p>";

	fclose($fp);
}

$query  = urldecode($_GET['query']);
$method  = urldecode($_GET['method']);
$search = urldecode($_GET['search']);
$MaxResults = 100;
echo $query;
echo $search;
RunTests( $query , $method, $search, $MaxResults);

?>

</body> 
</html> 
