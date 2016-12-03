
<?php

include_once "compare.php";

class SearchItem
{
    public $IsRanked;
	public $Engine;
	public $RANK;
    public $URL;
	public $SNIPPET;
	
 	public function  __construct($Engine, $RANK, $URL, $SNIPPET) {
		$this->Engine = $Engine;
		$this->RANK = $RANK;
		$this->URL = $URL;
		$this->SNIPPET = $SNIPPET;
		$IsRanked=FALSE;
	}	
}

function getNormalisedGoogleResults($query , $MaxResults){
    $normalisedArray = array();
    $ENGINE = "Google";
    $tries = 0;
    $start = 1;
    $NoOfResultsGathered = 0;
    $APIkey = 'AIzaSyDV00J7XkgomxdLOUtBmnq0_sU_qacG9xw';
    $CX = '011555459478186736951:lkjjpdebtx0';
    
    while(($NoOfResultsGathered < $MaxResults) && ($tries < 10)){
        $requestUri = "https://www.googleapis.com/customsearch/v1?q={$query}&key={$APIkey}&cx={$CX}&prettyPrint&start={$start}";
        $response = file_get_contents($requestUri); 
        $json = json_decode($response);
            if(is_object($json)){
                $NoOfResultsGathered = $NoOfResultsGathered + count($json->items);
                $Ranking = 100;
                    foreach ( $json->items as $value ) {
                        $URL = $value->link;
                        $SNIPPET = "";
                        if (isset($value->snippet)){
                            $SNIPPET = $value->snippet;
                        }else{
                            $SNIPPET = $value->url;
                        }
                        $normalisedArray[] = new SearchItem($ENGINE,$Ranking,$URL,$SNIPPET);
                        $Ranking--;
                    }
                $start = $start + 10;
            }
        $tries++;
    }
    return $normalisedArray;
}
/*
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
		$response = @file_get_contents($requestUri, 0, $context); 
		
		$json = json_decode($response); 
		
		$Engine = "Bing";

		
		if( is_object($json)  )
		{
		
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
   }
   
  // echo "\$NoOfResultsGathered". $NoOfResultsGathered;
   
   
   return $normalisedArray;
}
*/
//Bing version5 function
function getNormalisedBingResults($query , $MaxResults)
{
	
	$Rank = 100; //$MaxResults;
	$normalisedArray = array();
   
	// Logic to call the search engine
	// Logic to added to the normalised array

	$acctKey = 'f272db0528444b25b0070989564c1e6c';

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
		$requestUri = "https://api.cognitive.microsoft.com/bing/v5.0/search?responseFilter=Webpages&q=$query&count=$NoOfRssultstoResquest&offset=$NoToSkip&safesearch=off"; 

		
		// Encode the credentials and create the stream context.
		$auth = base64_encode("$acctKey:$acctKey");

		$data = array(

					'http' => array(

							'method' => "GET",

							'header' => "Ocp-Apim-Subscription-Key: $acctKey")

				);

				
		$context = stream_context_create($data);

		// Get the response from Bing.
		$response = @file_get_contents($requestUri, 0, $context); 
		
		$json = json_decode($response); 
		
		//var_dump($json);
		
		$Engine = "Bing";

		
		if( is_object($json)  )
		{
		
			$NoOfResultsGathered = $NoOfResultsGathered + count($json->webPages->value);

			$method = "https://";

			foreach ( $json->webPages->value as $value ) 
			{ 
								
                            if ( strpos($value->displayUrl, $method) === TRUE ) {
				
                                $URL = $value->displayUrl;
                                
                            } else {
				
                                $url = $value->displayUrl;
				$URL = substr_replace( $url, $method, 0, 0 );
                                
                            }
				
				$SNIPPET ="";
				if ( isset($value->snippet ) )
				{
					$SNIPPET = $value->snippet;
				} else {
					$SNIPPET = $value->name;
				}
				
				$normalisedArray[] =  new SearchItem($Engine,$Rank,$URL,$SNIPPET); 
				$Rank--;	
			}
		}
   }
   
  // echo "\$NoOfResultsGathered". $NoOfResultsGathered;
   
   
   return $normalisedArray;
   //print_r($normalisedArray);
}

function getNormalisedblekkoResults($query, $MaxResults)
{	
	// form the URL for the blekko request
	$APIKEY = 'f4c8acf3';
	$url = "http://blekko.com/ws/?q={$query}+/json&ps={$MaxResults}&auth={$APIKEY}";
	
		
	// Call blekko UrL and get response data
	$ch = curl_init($url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$data=curl_exec($ch);
	curl_close($ch);
	
	$json = json_decode($data);
	
	//for the normalised results
	$Engine="BLEKKO";
	$normalisedArray = array();
	$Ranking = 100;
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
    require_once("Oauth.php");  
     
    
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
		
		foreach($results->bossresponse->web->results as $item)
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
	
	for($i=0; $i < count($normalisedArray1Ranked); $i++)
	{
		if( $normalisedArray1Ranked[$i]->IsRanked == FALSE )
		{

		
			$sum = $normalisedArray1Ranked[$i]->RANK;  
		
			//Iterate through all the URLS in array 1 and compare  with array 2  
			for($j=0;$j< count($normalisedArray2);$j++)
			{
				if(cmpURL($normalisedArray1Ranked[$i]->URL, $normalisedArray2[$j]->URL)==0)
				{
					$sum = $sum + $normalisedArray2[$j]->RANK;
					$Engine  = $normalisedArray2[$j]->Engine;
					$RANK = $normalisedArray2[$j]->RANK;
					$URL = $normalisedArray2[$j]->URL;					
				}
			}
			
			//Iterate through all the URLS in array 1 and compare  with array 3  
			for($o=0; $o< count($normalisedArray3); $o++)		
			{
				if(cmpURL($normalisedArray1Ranked[$i]->URL, $normalisedArray3[$o]->URL)==0)
				{
					$sum = $sum + $normalisedArray3[$o]->RANK;
					$Engine  = $normalisedArray3[$o]->Engine;
					$RANK = $normalisedArray3[$o]->RANK;
					$URL = $normalisedArray3[$o]->URL;
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

function echoStartHtmlTableAggregated()
{
	echo "<table align=\"center\" border=\"1\">";
	echo "<thead><tr>";
	echo "<th>Rank</th>";
	echo "<th>Result</th>";
	echo "</tr></thead><tbody>";
}							
function echoEndHtmlTableAggregated()
{
	echo "</tbody></table>";
}								   			

function echoAsHtmltableRowAggregated($SearchItem, $j)
{	
		
		echo "<tr>";
		echo "<td>". ($j). "</td>";
		echo "<td><a href=$SearchItem->URL>". ($SearchItem->URL). "</a><p>" . ($SearchItem->SNIPPET) . "</p></td>";
		echo "</tr>";
	
}


				
function echoResultsAsTableRowsAggregated( $SearchItemArray, $MaxResults )
{	
	$j=1;
	for ($i = 0; $i < count($SearchItemArray); $i++)
	{	
		echoAsHtmltableRowAggregated($SearchItemArray[$i], $j); 
		$j++;
 	} 
	return;
}

function echoStartHtmlTableNON()
{
	echo "<table align=\"center\" border=\"1\">";
	echo "<thead><tr>";
	echo "<th>Rank</th>";
	echo "<th>Engine</th>";
	echo "<th>Result</th>";
	echo "</tr></thead><tbody>";
}									   

function echoEndHtmlTableNON()
{
	echo "</tbody></table>";
}							

function echoAsHtmltableRowNON($SearchItem, $j)
{	
		
		echo "<tr>";
		echo "<td>". ($j). "</td>";
		echo "<td>". ($SearchItem->Engine)."</td>";
		echo "<td><a href=$SearchItem->URL>". ($SearchItem->URL). "</a><p>" . ($SearchItem->SNIPPET) . "</p></td>";
		echo "</tr>";
	
}


				
function echoResultsAsTableRowsNON( $SearchItemArray, $MaxResults )
{	
	$j=1;
	for ($i = 0; $i < count($SearchItemArray); $i++)
	{	
		echoAsHtmltableRowNON($SearchItemArray[$i], $j); 
		$j++;
 	} 
	return;
}

function cmpRank($a, $b)
{
	if ($a->RANK == $b->RANK) 
       return 0;

    return ($a->RANK > $b->RANK) ? -1 : 1; //compares 
}

function search( $query, $MaxResults, $method )
{
	//echo "search(". $query . ",". $MaxResults. ",". $method. ")";
	
    //Call each search engine and insert results in a normalised array
        //Blekko Search API has currently been deprecated so blekko is bein replaced with Google
	//$normalisedArrayblekko = getNormalisedblekkoResults($query,$MaxResults);
	//echo "blekko count = ". count($normalisedArrayblekko);
        $normalisedArrayGoogle = getNormalisedGoogleResults($query, $MaxResults);
        
	$normalisedArrayYahoo = getNormalisedYahooResults($query,$MaxResults);
	//echo " Yahoo count = ". count($normalisedArrayYahoo);
	
	$normalisedArrayBing = getNormalisedBingResults($query,$MaxResults);
	//echo " Bing count = ". count($normalisedArrayBing);
	
	if( $method =='aggregation')
	{
		//rank the arrays
                $normalisedArrayGoogleRanked = Rank($normalisedArrayGoogle, $normalisedArrayGoogle, $normalisedArrayBing);
		//$normalisedArrayblekkoRanked = Rank( $normalisedArrayblekko, $normalisedArrayYahoo, $normalisedArrayBing);
		$normalisedArrayYahooRanked = Rank( $normalisedArrayYahoo, $normalisedArrayBing, $normalisedArrayGoogle);
		$normalisedArrayBingRanked = Rank( $normalisedArrayBing, $normalisedArrayGoogle, $normalisedArrayYahoo);


		//Merge all data together  
		$normalisedArray = array_merge(  $normalisedArrayBingRanked, $normalisedArrayGoogleRanked, $normalisedArrayYahooRanked);
			

		// Sort Items in order of descending Ranks
		usort($normalisedArray, "cmpRank");
		
		// remove duplicates
		$normalisedArrayUnique = array();
		$filtered = array();
		foreach ($normalisedArray as $item)
		{
			if(in_array($item->URL, $filtered))
			{
				continue;
			}
			array_push($filtered, $item->URL);
			array_push($normalisedArrayUnique, $item); 
		}
		
		unset($filtered);
		unset($normalisedArray);
		
		// limit to MAX results
		$normalisedArray =  array_slice($normalisedArrayUnique,0, $MaxResults);
		
	}
	else if($method == 'non-aggregation'){
                if($MaxResults === 10){
                    $normalisedArrayGoogle_100 = array_slice($normalisedArrayGoogle, 0, 10);
                    $normalisedArrayBing_100 = array_slice($normalisedArrayBing, 0, 10);
                    $normalisedArrayYahoo_100 = array_slice($normalisedArrayYahoo, 0, 10);
                }elseif($MaxResults === 50){
                    $normalisedArrayGoogle_100 = array_slice($normalisedArrayGoogle, 0, 50);
                    $normalisedArrayBing_100 = array_slice($normalisedArrayBing, 0, 50);
                    $normalisedArrayYahoo_100 = array_slice($normalisedArrayYahoo, 0, 50);
                }elseif($MaxResults === 100){
                    $normalisedArrayGoogle_100 = array_slice($normalisedArrayGoogle, 0, 100);
                    $normalisedArrayBing_100 = array_slice($normalisedArrayBing, 0, 100);
                    $normalisedArrayYahoo_100 = array_slice($normalisedArrayYahoo, 0, 100);
                }else{
                    $normalisedArrayGoogle_100 = array_slice($normalisedArrayGoogle, 0, 100);
                    $normalisedArrayBing_100 = array_slice($normalisedArrayBing, 0, 100);
                    $normalisedArrayYahoo_100 = array_slice($normalisedArrayYahoo, 0, 100);
                }
                //Google has replace $normalisedArrayBlekko as Blekko has been deprecated
		$normalisedArray = array_merge( $normalisedArrayGoogle_100, $normalisedArrayBing_100, $normalisedArrayYahoo_100);
	}
	
	return $normalisedArray;
}





?>
