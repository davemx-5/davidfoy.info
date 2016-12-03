
<?php


class RefItem
{
	public $Engine;
    public $URL;
	public $RANK;
	
	public function  __construct($Engine, $RANK, $URL ) {
		$this->Engine = $Engine;
		$this->RANK = $RANK;
		$this->URL = $URL;
	}
}

class SearchItem
{
    public $IsRanked;
	public $Engine;
	public $RANK;
    public $URL;
	public $SNIPPET;
	public $foundArray;
	
	
	public function  add($Engine, $RANK, $URL ) {
		$this->foundArray[] = new RefItem($Engine, $RANK, $URL);
	}
	
 	public function  __construct($Engine, $RANK, $URL, $SNIPPET) {
		$this->Engine = $Engine;
		$this->RANK = $RANK;

		$this->URL = $URL;
		$this->SNIPPET = $SNIPPET;
		$IsRanked=FALSE;
		$foundArray = array();	
		$foundArray[] = new RefItem($Engine, $RANK, $URL);
	}	
}

function getNormalisedBingResults($query , $MaxResults)
{
	
	$Rank = 100; //$MaxResults;
	$normalisedArray = array();
   
	// Logic to call the search engine
	// Logic to added to the normalised array

	$acctKey = 'Ip6w3psNS9bsISwyx3bVtnqCPQuzcCxTOIUnXkRw3VA';

	// Encode the query and the single quotes that must surround it.
	
	$Tries=0;
    $NoOfResultsGathered = 0;
	while ( ($NoOfResultsGathered < $MaxResults ) && ( $Tries < 5) )
	{
		$Tries++; // used as safety just in case caught in a loop
		$NoToSkip = 0;
		$NoOfRssultstoResquest = 50;
		if( $MaxResults <= 50) // less than 50
		{
			$NoToSkip = 0;
			$NoOfRssultstoResquest = $MaxResults;
		}
		else // 100
        {
			$NoOfRssultstoResquest = 50;
			$NoToSkip = 50 ;
		}		
			
		// Construct the full URI for the query.
		$requestUri = "https://api.datamarket.azure.com/Bing/Search/Web?\$format=json&Query=$query&\$top=$NoOfRssultstoResquest&\$skip=$NoToSkip"; 

		
		// Encode the credentials and create the stream context.
		$auth = base64_encode("$acctKey:$acctKey");

		$data = array(

					'http' => array(

							'request_fulluri' => true,

							// ignore_errors can help debug – remove for production. This option added in PHP 5.2.10

							'ignore_errors' => true,

							'header' => "Authorization: Basic $auth")

				);

				
		$context = stream_context_create($data);

		// Get the response from Bing.
		$response = file_get_contents($requestUri, 0, $context); 
		
		$json = json_decode($response); 
		
		$Engine = "Bing";

		$NoOfResultsGathered = $NoOfResultsGathered + count($json->d->results);

		foreach ( $json->d->results as $value ) 
		{ 
		
			$URL = $value->Url;
			
			$SNIPPET ="";
			if ( isset($value->Description ) )
			{
				$SNIPPET = $value->Description;
			}
			else
			{
				$SNIPPET = $value->Title;
			}
			
			
			$normalisedArray[] =  new SearchItem($Engine,$Rank,$URL,$SNIPPET); 
			$Rank--;	
		}
   }
   
  // echo "\$NoOfResultsGathered". $NoOfResultsGathered;
   
   
   return $normalisedArray;
}

function getNormalisedBekkoResults($query, $MaxResults)
{	
	// form the URL for the Bekko request
	$APIKEY = 'f4c8acf3';
	$url = "http://blekko.com/ws/?q={$query}/json+/ps={$MaxResults}&auth={$APIKEY}";
	
		
	// Call Bekko UrL and get response data
	$ch = curl_init($url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$data=curl_exec($ch);
	curl_close($ch);
	
	$json = json_decode($data);
	//print_r($json);
	//for the normalised results
	
	
	$Engine="BLEKKO";
	$normalisedArray = array();
	$Ranking = 100;
//	$Ranking = count($json->RESULT);
	foreach($json->RESULT as $item)
	{	
		
		$URL = $item->url;	
		$SNIPPET ="";
		
		if ( isset($item->snippet ) )
		{
			$SNIPPET = ($item->snippet);
		}
		else
		{
			$SNIPPET = ($item->url);
		}
		$normalisedArray[] =  new SearchItem($Engine,$Ranking,$URL,$SNIPPET); 
	
		$Ranking--;
	}


	return $normalisedArray;
}

function getNormalisedYahooResults($query , $MaxResults)
{
	$normalisedArray = array();
   
	// Logic to call the search engine
    require("Oauth.php");  
     
    
	$NoRequests=1;
	if ($MaxResults > 50 )
	{
	   // make two request 
		$NoRequests=2;
	}
	
	$Ranking = 100;
	$Engine = "YAHOO";
	$normalisedArray = array();
	
	
	//echo "<DIV ID=\"DEBUG\">";
	
	//echo "NoRequests=". $NoRequests;
	
	for ($i = 0; $i < $NoRequests; $i++) 
	{	
		// form the URL
		$cc_key  = "dj0yJmk9M3pjdFllMFdnYjdDJmQ9WVdrOWFUZEVOSE5sTXpJbWNHbzlNVFU1Tnprd05EVTJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD00YQ--";  
		$cc_secret = "e76a31d86beb66b6ce279b46546a1850e8e7023f";  
		$url = "http://yboss.yahooapis.com/ysearch/news,web,images";  
		$args = array();  
		$args["q"] = "{$query}";  
		$args["format"] = "json";  
		
		if( ( $NoRequests == 1 ) && ($i==0) ) // request is less 50
		{
			$args["start"] = "0";
			$args["count"] = "{$MaxResults}";
		}
		else if( ( $NoRequests == 2 ) && ($i==0) ) // request is 100 and its the first request of 2 
		{
			$args["start"] = "0";
			$args["count"] = "50";
		}
		else if( ( $NoRequests == 2 ) && ($i==1) ) // request is 100 and its the second request of 2 
		{
			$args["start"] = "50";
			$args["count"] = "50";
		}
		
		$consumer = new OAuthConsumer($cc_key, $cc_secret);  
		$request = OAuthRequest::from_consumer_and_token($consumer, NULL,"GET", $url, $args);  
		$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);  
		$url = sprintf("%s?%s", $url, OAuthUtil::build_http_query($args));  
		$ch = curl_init();  
		$headers = array($request->to_header());  
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
		curl_setopt($ch, CURLOPT_URL, $url);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
		$rsp = curl_exec($ch);  
		$results = json_decode($rsp);  
		
		//echo($results);
		//$Ranking = $MaxResults;
		
		foreach($results ->bossresponse->web->results as $item)
		{
			
					
			$URL = ($item->url);
			
			if(isset( $item->abstract)){
				$SNIPPET = ($item->abstract);
			} else {
				$SNIPPET = "snip not set";
			}
			
			$normalisedArray[] = new SearchItem($Engine, $Ranking, $URL, $SNIPPET);
			
			$Ranking--;
					
		}		
		unset($results);

		
	}
	
   //echo "<DIV>";
	
				
   return $normalisedArray;
}

function cmpURL($URL1, $URL2)
{
	$URL1NEW=$URL1;
	$URL2NEW=$URL2;
	
	$URL1NEW=str_replace("http://", "", $URL1);
	$URL1NEW=str_replace("https://", "", $URL1);
	$URL2NEW=str_replace("http://", "", $URL2);
	$URL2NEW=str_replace("https://", "", $URL2);
	
	
	
	$result = strcmp( $URL1NEW, $URL2NEW );
	
	/*
	$log=  "URL1=". ($URL1). "\n". 
		   "URL2=". ($URL2). "\n".  	
		   "URL1NEW=". ($URL2NEW). "\n".  	
		   "URL2NEW=". ($URL2NEW). "\n". 
		   "Result=". ($Result). "\n" ;
	file_put_contents('log2.txt', $log,FILE_APPEND);
	*/
	return $result;
}		

function array_copy($arr) {
    $newArray = array();
    foreach($arr as $key => $value) {
        if(is_array($value)) $newArray[$key] = array_copy($value);
        elseif(is_object($value)) $newArray[$key] = clone $value;
        else $newArray[$key] = $value;
    }
    return $newArray;
}

function rank( $normalisedArray1, $normalisedArray2, $normalisedArray3)
{
	$normalisedArray1Ranked = array_copy($normalisedArray1);
	
	$sum = 0;
	
	for($i=0; $i <= count($normalisedArray1Ranked); $i++)
	{
		if( $normalisedArray1Ranked[$i]->IsRanked == FALSE )
		{

		
			$sum = $normalisedArray1Ranked[$i]->RANK;  
		
			//Iterate through all the URLS in array 1 and compare  with array 2  
			for($j=0;$j<=count($normalisedArray2);$j++)
			{
				if(cmpURL($normalisedArray1Ranked[$i]->URL, $normalisedArray2[$j]->URL)==0)
				{
					$sum = $sum + $normalisedArray2[$j]->RANK;
					
					
					$Engine  = $normalisedArray2[$j]->Engine;
					$RANK = $normalisedArray2[$j]->RANK;
					$URL = $normalisedArray2[$j]->URL;
					
					//$normalisedArray1Ranked[$i]->foundArray[] = new RefItem($Engine, $RANK, $URL);

				}
			}
			
			//Iterate through all the URLS in array 1 and compare  with array 3  
			for($o=0; $o<=count($normalisedArray3); $o++)		
			{
				if(cmpURL($normalisedArray1Ranked[$i]->URL, $normalisedArray3[$o]->URL)==0)
				{
					$sum = $sum + $normalisedArray3[$o]->RANK;

					$Engine  = $normalisedArray3[$o]->Engine;
					$RANK = $normalisedArray3[$o]->RANK;
					$URL = $normalisedArray3[$o]->URL;
					
					//$normalisedArray1Ranked[$i]->foundArray[] = new RefItem($Engine, $RANK, $URL);
			

				}
			}
			
			// Assign new value of RANK and mark items as ranked
			if ($sum > $normalisedArray1Ranked[$i]->RANK ) 
			{
				$normalisedArray1Ranked[$i]->RANK = $sum;
				$normalisedArray1Ranked[$i]->IsRanked=TRUE;
			}
		
		}
		
	}
	
	return $normalisedArray1Ranked;

}

function echoStartHtmlTable()
{
	echo "<table border=\"1\">";
	echo "<thead><tr>";
	echo "<th>Rank</th>";
	echo "<th>Engine</th>";
	echo "<th>Result</th>";
	echo "<th>Number of finds</th>";
	echo "<th>Precision</th>";  //  relevance / Resultset
	echo "<th>Relevence</th>"; // how many times it was found in the mast list
	echo "<th>Recall</th>"; //proportion of relevant retrieved amongst  relevant items
	echo "</tr></thead><tbody>";
}									   

function echoEndHtmlTable()
{
	echo "</tbody></table>";
}							

function echoAsHtmltableRow($SearchItem)
{	
		echo "<tr>";
		echo "<td>". ($SearchItem->RANK). "</td>";
		echo "<td>". ($SearchItem->Engine)."</td>";

		//if(($SearchItem->SNIPPET)!=NULL)
		//{
		//	echo "<td><a href=\"". ($SearchItem->URL). "\">". ($SearchItem->SNIPPET). "</a></td>";
		//}
		//if(($SearchItem->SNIPPET) == NULL)
		//{
			echo "<td><a href=$SearchItem->URL>". ($SearchItem->URL). "</a></td>";
		//}
	
     	echo "<td>";
		// for ($i = 0; $i < count($SearchItem->foundArray); $i++) 
		// {
			// echo ($SearchItem->foundArray[$i]->RANK). ", ";
			// echo ($SearchItem->foundArray[$i]->Engine).", ";
			// echo "<a href=$SearchItem->URL>". ($SearchItem->foundArray[$i]->URL). "</a> <br>";
		// }
		echo "</td>";
		
		
		
		
		echo "</tr>";
	
}

				
function echoResultsAsTableRows( $SearchItemArray, $MaxResults )
{
	for ($i = 0; $i < count($SearchItemArray); $i++) {

	    if ($i > $MaxResults) 
			break; 
		
		echoAsHtmltableRow($SearchItemArray[$i]); 
    
	   
	
	} 
	return;
}

function cmpRank($a, $b)
{
	if ($a->RANK == $b->RANK) 
       return 0;

    return ($a->RANK > $b->RANK) ? -1 : 1; //compares 
}

function delete_duplicates($normalisedArray)
{
	$noduplicates = array();
	foreach($normalisedArray->URL as $URL)
	{
		if(in_array( $URL, $noduplicates))
		{
			continue;		
		}
		array_push($noduplicates, $normalisedArray);
	}

	return $noduplicates;
}


function agragate( $query, $MaxResults, $method )
{
	$normalisedArray = array();
	
    //Call each search engine and insert results in a normalised array 
	$normalisedArrayBekko = getNormalisedBekkoResults($query,$MaxResults);
	$normalisedArrayYahoo = getNormalisedYahooResults($query,$MaxResults);
	$normalisedArrayBing = getNormalisedBingResults($query,$MaxResults);
	
	if( $method =='aggregation')
	{
		//rank the arrays
		$normalisedArrayBekkoRanked = Rank( $normalisedArrayBekko, $normalisedArrayYahoo, $normalisedArrayBing);
		$normalisedArrayYahooRanked = Rank( $normalisedArrayYahoo, $normalisedArrayBing, $normalisedArrayBekko);
		$normalisedArrayBingRanked = Rank( $normalisedArrayBing, $normalisedArrayBekko, $normalisedArrayYahoo);


		//Merge all data together  
		$normalisedArray = array_merge(  $normalisedArrayBingRanked, $normalisedArrayBekkoRanked, $normalisedArrayYahooRanked);
		
		$no_duplicates = function delete_duplicates($normalisedArray);

		// Sort Items in order of descending Ranks
		usort($no_duplicates, "cmpRank");
		
	}
	else if($method == 'non-aggregation')
	{
		$normalisedArray = array_merge( $normalisedArrayBekko, $normalisedArrayBing, $normalisedArrayYahoo);
	}
	
	return $normalisedArray;
}





?>
