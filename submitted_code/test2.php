<?php

include_once "compare.php";

function ReadTestDataIntoXMLDom()
{
	$linesrq = file("relevantquery.txt");
	$linesQueries = file("queries.txt");

	$dom = new DOMDocument("1.0");
	// create root element
	$root = $dom->createElement("Test-Data");
	$dom->appendChild($root);
	$dom->formatOutput=true;

	$i = 0;		
    foreach ($linesQueries as $queryValue)
	{
		// //SearchItem
		// create child element
		$searchitem = $dom->createElement("SearchItem");
		$root->appendChild($searchitem );

		//SearchItem/query
		// create attribute node
		$queryattribute = $dom->createAttribute("Query");
		$searchitem->appendChild($queryattribute);
		
		//SearchItem/query/list
		// create attribute value node
		$string = preg_replace("/[\\n\\r]+/", "", $queryValue);
		
		$queryValueNode = $dom->createTextNode( $string );
		$queryattribute->appendChild($queryValueNode);

			// create child element
		$searchitemListNode = $dom->createElement("SearchList");
		$searchitem->appendChild($searchitemListNode);

		$indx=0;
		for ($indx=0; $indx < 100; $indx++   )
		{
			$data = explode(" ", $linesrq[$i+$indx] );
			$URL = preg_replace("/[\\n\\r]+/", "", $data[1]);
	
			// create child element
			$searchitemListItem = $dom->createElement("SearchListItem");
			$searchitemListNode->appendChild($searchitemListItem);
	
			// create attribute value node
			$searchitemListItemValue = $dom->createTextNode($URL);
			$searchitemListItem->appendChild($searchitemListItemValue);
		}	
		
		$i=$i+100;
		
	}
	//$dom->save('search.xml');
	return $dom;
}

function getReferenceURLSForQuery( $dom , $query ) 
{
    $xpath = new DOMXPath($dom);
    $SearchListItems = $xpath->query("//Test-Data/SearchItem[@Query='$query']/SearchList/*");
	$URLS = array();
	for ($i = 0; $i < $SearchListItems->length; $i++) 
	{
		$URL = $SearchListItems->item($i)->nodeValue;
		array_push($URLS,$URL);
	}	
	return $URLS;
}

function getReferenceQueries( $dom ) 
{
    $xpath = new DOMXPath($dom);
    $SearchListItems = $xpath->query("//Test-Data/*");
	$queries = array();
	for ($i = 0; $i < $SearchListItems->length; $i++) 
	{
		$query = $SearchListItems->item($i)->getAttribute('Query');
		array_push($queries,$query);
	}	
	return $queries;
}

function getReleventFindsForMetaSearchResultsComparedToGoldStandard($RefURLS, $normalisedArray)
{
	$num_of_relevant_found = 0;
	
	//count through two arrays and compare the results and take an account of the number of matches (relevance)
	for($i =0; $i < count($RefURLS); $i++)
	{	
		for($j = 0; $j < count($normalisedArray); $j++)
		{
			if(cmpURL($RefURLS[$i], $normalisedArray[$j]->URL)==0)
			{	
				$num_of_relevant_found++;
			}
		}
	}
	return $num_of_relevant_found;
}

function getPrecision($NoOfReleventResults, $MaxResults)
{
	return (($NoOfReleventResults / $MaxResults) * 100);
}

function getRecall($NoOfReleventResults, $RefURLS)
{
	return (($NoOfReleventResults / count($RefURLS)) * 100);
}

function precisionAtTen($RefURLS, $normalisedArray)
{
	$num_of_relevant_found = 0;
	for($i = 0; $i < count($RefURLS); $i++)
	{	
		for($j = 0; $j < 10; $j++)
		{
			if(cmpURL($RefURLS[$i], $normalisedArray[$j]->URL)==0)
			{	
				$num_of_relevant_found++;
			}
		}
	} 
	return (($num_of_relevant_found/10)*100);
}

function f_measure($precision, $recall)
{
	return (2 * (($precision * $recall)/($precision + $recall)));
}

function ave_precision($precision, $recall, $normalisedArray)
{
	return ($precision / 100);
	//return (($precision * $recall) / count($normalisedArray));
}
?>